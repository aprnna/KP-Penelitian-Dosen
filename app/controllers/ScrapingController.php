<?php

require_once '../app/services/ApiService.php';
require_once '../app/helpers/response_helper.php';
require_once '../app/helpers/pagination_helper.php';

class ScrapingController extends Controller
{
    private $auth;
    private $api;

    public function __construct()
    {
        $this->auth = new Auth();

        if (!$this->auth->check()) {
            $this->redirect("auth/login");
            return;
        }

        $this->api = new ApiService();
    }

    public function index()
    {
        $authorModel = $this->model("Author");
        $authorsRaw = $authorModel->getAllAuthors();
        $authorsForScrape = [];

        foreach ($authorsRaw as $author) {
            $idSinta = isset($author->id_sinta) ? (int) $author->id_sinta : 0;
            if ($idSinta <= 0) {
                continue;
            }

            $authorsForScrape[] = [
                "id_sinta" => $idSinta,
                "fullname" => (string) ($author->fullname ?? "-"),
            ];
        }

        usort($authorsForScrape, function ($a, $b) {
            return strcmp($a["fullname"], $b["fullname"]);
        });

        $data = [
            "title" => "Scraping Dashboard",
            "user" => $this->auth->user(),
            "showNavbar" => true,
            "showFooter" => true,
            "currentPage" => "scraping",
            "authorsForScrape" => $authorsForScrape,
        ];

        $this->render("scraping/index", $data, "main");
    }


    public function triggerScraping()
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                throw new ApiException("Method not allowed", 405);
            }

            $body = json_decode(file_get_contents("php://input"), true) ?? [];
            $source = $body["source"] ?? "sinta_authors";

            $validSources = ["sinta_authors", "sinta_articles", "both"];
            if (!in_array($source, $validSources)) {
                throw new ApiException("Invalid source: " . $source, 400);
            }

            $payload = ["source" => $source];

            if ($source === "sinta_articles" && !empty($body["sinta_ids"])) {
                $payload["sinta_ids"] = array_map("intval", $body["sinta_ids"]);
            }

            $apiResponse = $this->api->request("/api/v1/scrape", "POST", $payload);

            if (empty($apiResponse["job_id"])) {
                throw new ApiException("job_id missing from API", 500);
            }

            jsonResponse([
                "message" => $apiResponse["message"] ?? "Scraping job started.",
                "job_id" => $apiResponse["job_id"],
            ]);
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }


    public function syncAuthors()
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                errorResponse("Method not allowed", 405);
            }

            $page = 1;
            $size = 200;
            $allAuthors = [];

            while (true) {
                $result = $this->api->request(
                    "/api/v1/sinta-authors?page={$page}&size={$size}"
                );

                $pageData = $result["data"];

                if (empty($pageData) || !is_array($pageData)) {
                    break;
                }

                $allAuthors = array_merge($allAuthors, $pageData);

                // If fewer rows returned than requested, this was the last page
                if (count($pageData) < $size) {
                    break;
                }

                $page++;
            }

            if (empty($allAuthors)) {
                jsonResponse([
                    "message" => "No authors found in backend — nothing to sync.",
                    "stats" => [
                        "total" => 0,
                        "updated" => 0,
                        "inserted" => 0,
                        "skipped" => 0,
                    ],
                ]);
            }

            $authorModel = $this->model("Author");

            $stats = [
                "total" => count($allAuthors),
                "updated" => 0,
                "inserted" => 0,
                "skipped" => 0,
                "errors" => 0,
            ];
            $skippedDetails = [];

            foreach ($allAuthors as $sintaAuthor) {
                $rawId = $sintaAuthor["id_sinta"] ?? null;
                $idSinta = isset($rawId) ? intval($rawId) : null;
                $fullname = (string) ($sintaAuthor["fullname"] ?? $sintaAuthor["nama"] ?? "-");

                if (!$idSinta) {
                    $stats["skipped"]++;
                    $skippedDetails[] = [
                        "fullname" => $fullname,
                        "id_sinta" => $rawId,
                        "reason" => $rawId === null || $rawId === ""
                            ? "ID SINTA kosong (null)"
                            : "ID SINTA tidak valid (" . var_export($rawId, true) . ")",
                    ];
                    continue;
                }

                try {
                    $localAuthor = $authorModel->getAuthorById($idSinta);

                    if ($localAuthor) {
                        // Only update if any of the SINTA-sourced fields have changed
                        $changed = $this->sintaFieldsChanged(
                            $localAuthor,
                            $sintaAuthor
                        );

                        if ($changed) {
                            $authorModel->updateFromSinta($idSinta, $sintaAuthor);
                            $stats["updated"]++;
                        } else {
                            $stats["skipped"]++;
                            $skippedDetails[] = [
                                "fullname" => $fullname,
                                "id_sinta" => $idSinta,
                                "reason" => "Tidak ada perubahan data",
                            ];
                        }
                    } else {
                        // New author — insert with scraped data (nidn/degree/faculty remain NULL)
                        $authorModel->insertFromSinta($sintaAuthor);
                        $stats["inserted"]++;
                    }
                } catch (Exception $e) {
                    $stats["errors"]++;
                    $skippedDetails[] = [
                        "fullname" => $fullname,
                        "id_sinta" => $idSinta,
                        "reason" => "Error DB: " . $e->getMessage(),
                    ];
                    error_log(
                        "[syncAuthors] id_sinta=" .
                            $idSinta .
                            " error: " .
                            $e->getMessage()
                    );
                }
            }

            $msg =
                "Sync complete — {$stats["updated"]} updated, {$stats["inserted"]} inserted, " .
                "{$stats["skipped"]} unchanged" .
                ($stats["errors"] > 0
                    ? ", {$stats["errors"]} errors (see server log)"
                    : "") .
                ".";

            jsonResponse([
                "success" => true,
                "message" => $msg,
                "stats" => $stats,
                "skipped_details" => $skippedDetails,
            ]);
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }

    public function syncArticles()
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                errorResponse("Method not allowed", 405);
            }

            $articleModel = $this->model("Article");

            $page = 1;
            $size = 200;
            $stats = [
                "total_fetched" => 0,
                "processed" => 0,
                "inserted" => 0,
                "updated" => 0,
                "skipped" => 0,
                "relations_added" => 0,
                "relation_skipped" => 0,
                "errors" => 0,
            ];

            while (true) {
                $apiResult = $this->api->request("/api/v1/sinta-articles?page={$page}&size={$size}");
                $rows = $this->extractRemoteArticles($apiResult);

                if (empty($rows)) {
                    break;
                }

                $stats["total_fetched"] += count($rows);

                foreach ($rows as $rawArticle) {
                    try {
                        $article = $this->normalizeRemoteArticle($rawArticle);
                        if ($article === null) {
                            $stats["skipped"]++;
                            continue;
                        }

                        $idSinta = isset($article["id_sinta"]) ? (int) $article["id_sinta"] : 0;
                        if ($idSinta <= 0 || !$articleModel->authorExists($idSinta)) {
                            $stats["skipped"]++;
                            $stats["relation_skipped"]++;
                            continue;
                        }

                        $upsertResult = $articleModel->upsertFromSintaArticle($article);
                        $upsertStatus = is_array($upsertResult) ? ($upsertResult["status"] ?? null) : $upsertResult;
                        $resolvedIdArticle = is_array($upsertResult) ? (int) ($upsertResult["id_article"] ?? 0) : 0;

                        if ($upsertStatus === "inserted") {
                            $stats["inserted"]++;
                        } elseif ($upsertStatus === "updated") {
                            $stats["updated"]++;
                        } else {
                            $stats["skipped"]++;
                        }

                        $stats["processed"]++;

                        if ($resolvedIdArticle > 0) {
                            $linked = $articleModel->ensureAuthorArticleRelation(
                                $idSinta,
                                $resolvedIdArticle
                            );
                            if ($linked) {
                                $stats["relations_added"]++;
                            } else {
                                $stats["relation_skipped"]++;
                            }
                        } else {
                            $stats["relation_skipped"]++;
                        }
                    } catch (Exception $e) {
                        $stats["errors"]++;
                        error_log("[syncArticles] error: " . $e->getMessage());
                    }
                }

                if (count($rows) < $size) {
                    break;
                }

                $page++;
            }

            if ($stats["total_fetched"] === 0) {
                jsonResponse([
                    "message" => "No remote article data found.",
                    "stats" => $stats,
                ]);
            }

            $message =
                "Sync articles complete - {$stats["inserted"]} inserted, {$stats["updated"]} updated, " .
                "{$stats["skipped"]} unchanged/skipped, {$stats["relations_added"]} relations added" .
                ($stats["errors"] > 0 ? ", {$stats["errors"]} errors (see server log)" : "") .
                ".";

            jsonResponse([
                "message" => $message,
                "stats" => $stats,
            ]);
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }


    public function previewSyncAuthors()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            errorResponse("Method not allowed", 405);
        }

        try {
            $preview = $this->buildSyncPreviewData();

            jsonResponse([
                "data" => [
                    "inserted" => $preview["inserted"],
                    "updated" => $preview["updated"],
                    "stats" => $preview["stats"],
                    "skipped_details" => $preview["skipped_details"] ?? [],
                ]
            ]);
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }

    public function previewSyncAuthorsPage()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "GET") {
            errorResponse("Method not allowed", 405);
        }

        try {
            $preview = $this->buildSyncPreviewData();

            $data = [
                "title" => "Preview Sync Authors",
                "user" => $this->auth->user(),
                "showNavbar" => true,
                "showFooter" => true,
                "currentPage" => "scraping",
                "inserted" => $preview["inserted"],
                "updated" => $preview["updated"],
                "stats" => $preview["stats"],
                "skipped_details" => $preview["skipped_details"] ?? [],
            ];

            $this->render("scraping/preview_sync_authors", $data, "main");
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }

    public function previewSyncArticlesPage()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "GET") {
            errorResponse("Method not allowed", 405);
        }

        try {
            $preview = $this->buildSyncArticlesPreviewData();

            $data = [
                "title" => "Preview Sync Articles",
                "user" => $this->auth->user(),
                "showNavbar" => true,
                "showFooter" => true,
                "currentPage" => "scraping",
                "inserted" => $preview["inserted"],
                "updated" => $preview["updated"],
                "stats" => $preview["stats"],
            ];

            $this->render("scraping/preview_sync_articles", $data, "main");
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }

    public function executeSyncAuthors()
    {

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            errorResponse("Method not allowed", 405);
        }

        $body = json_decode(file_get_contents("php://input"), true);
        if (!$body || !isset($body["inserted"]) || !isset($body["updated"])) {
            echo json_encode([
                "success" => false,
                "message" => "Invalid payload format.",
            ]);
            exit();
        }

        $authorModel = $this->model("Author");
        $stats = [
            "inserted" => 0,
            "updated" => 0,
            "errors" => 0,
        ];

        // Insert new authors
        foreach ($body["inserted"] as $sintaAuthor) {
            try {
                $authorModel->insertFromSinta($sintaAuthor);
                $stats["inserted"]++;
            } catch (Exception $e) {
                $stats["errors"]++;
                error_log("[executeSyncAuthors] Insert error: " . $e->getMessage());
            }
        }

        // Update existing authors
        foreach ($body["updated"] as $sintaAuthor) {
            try {
                $idSinta = intval($sintaAuthor["id_sinta"]);
                if ($idSinta) {
                    $authorModel->updateFromSinta($idSinta, $sintaAuthor);
                    $stats["updated"]++;
                }
            } catch (Exception $e) {
                $stats["errors"]++;
                error_log("[executeSyncAuthors] Update error (id_sinta={$sintaAuthor['id_sinta']}): " . $e->getMessage());
            }
        }

        $msg = "Sync complete — {$stats['updated']} updated, {$stats['inserted']} inserted" .
            ($stats["errors"] > 0 ? ", {$stats['errors']} errors (see server log)" : "") . ".";

        jsonResponse([
            "message" => $msg,
            "stats" => $stats,
        ]);
    }

    private function sintaFieldsChanged($local, array $remote): bool
    {
        $fields = [
            "sinta_score_overall",
            "sinta_score_3yr",
            "affil_score",
            "affil_score_3yr",
            "subject_research",
            "degree",
            "major",
            "faculty",
            "s_article_scopus",
            "s_citation_scopus",
            "s_cited_document_scopus",
            "s_hindex_scopus",
            "s_i10_index_scopus",
            "s_gindex_scopus",
            "s_article_gscholar",
            "s_citation_gscholar",
            "s_cited_document_gscholar",
            "s_hindex_gscholar",
            "s_i10_index_gscholar",
            "s_gindex_gscholar",
        ];

        $normalize = function ($val, $field) {
            if ($val === null) {
                return null;
            }

            // Degree: uppercase, trim, empty -> null
            if ($field === "degree") {
                $v = trim((string) $val);
                return $v === "" ? null : strtoupper($v);
            }

            // Major or subject_research: trim and collapse multiple spaces
            if ($field === "major" || $field === "subject_research") {
                $v = trim((string) $val);
                $v = preg_replace('/\s+/u', ' ', $v);
                return $v === "" ? null : $v;
            }

            // Default: trim and treat empty as null
            $v = trim((string) $val);
            return $v === "" ? null : $v;
        };

        foreach ($fields as $field) {
            $localVal = $local->{$field} ?? null;
            $remoteVal = isset($remote[$field]) ? $remote[$field] : null;

            $nLocal = $normalize($localVal, $field);
            $nRemote = $normalize($remoteVal, $field);

            if ($nLocal !== $nRemote) {
                return true;
            }
        }

        return false;
    }

    public function getJobs()
    {
        try {
            $params = [];

            if (!empty($_GET["status"])) {
                $params["status"] = $_GET["status"];
            }

            $limit = !empty($_GET["limit"]) ? (int) $_GET["limit"] : 20;
            $params["limit"] = $limit;

            if (!empty($_GET["page"])) {
                $params["offset"] = ((int) $_GET["page"] - 1) * $limit;
            }

            $queryString = http_build_query($params);
            $result = $this->api->request("/api/v1/jobs?" . $queryString);

            $apiData = $result;
            $page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;

            jsonResponse(
                paginate(
                    $apiData["jobs"] ?? [],
                    $apiData["total"] ?? 0,
                    $page,
                    $limit
                )
            );
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }

    public function getJobDetails($jobUuid)
    {
        try {
            $result = $this->api->request("/api/v1/jobs/" . $jobUuid);

            $apiData = $result;
            $job = $apiData["job"] ?? null;
            $logs = $job["run_logs"] ?? [];

            if (!$job) {
                errorResponse(
                    "Job not found.",
                    404
                );
            }

            $logCounts = ["DEBUG" => 0, "INFO" => 0, "WARNING" => 0, "ERROR" => 0];
            foreach ($logs as $log) {
                $level = strtoupper($log["level"] ?? "INFO");
                if (isset($logCounts[$level])) {
                    $logCounts[$level]++;
                }
            }

            $duration = null;
            $durationSeconds = $this->resolveJobDurationSeconds($job);
            if ($durationSeconds !== null) {
                $duration = $this->formatDurationFromSeconds($durationSeconds);
            }

            jsonResponse([
                "data" => [
                    "job" => $job,
                    "logs" => $logs,
                    "duration" => $duration,
                    "progress_percentage" => $this->resolveJobProgressPercentage($job),
                    "log_counts" => $logCounts,
                    "is_running" => $job["status"] === "running",
                    "is_finished" => $job["status"] === "finished",
                    "is_failed" => $job["status"] === "failed",
                ]
            ]);
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }

    public function getJobProgress($jobUuid)
    {
        try {
            $api = $this->api->request("/api/v1/jobs/" . $jobUuid);
            $result = $api;

            $job = $result["job"] ?? null;

            if (!$job) {
                errorResponse("Job not found.", 404);
            }

            // Calculate elapsed seconds since job started
            $elapsedSeconds = 0;
            $estimatedRemaining = null;

            $knownDuration = $this->resolveJobDurationSeconds($job);
            if ($knownDuration !== null && ($job["status"] ?? "") !== "running") {
                $elapsedSeconds = $knownDuration;
            } elseif (!empty($job["started_at"])) {
                $startTs = strtotime($job["started_at"]);
                if ($startTs !== false) {
                    $elapsedSeconds = max(0, time() - $startTs);
                }

                if ($job["processed_records"] > 0 && $job["total_records"] > 0) {
                    $avgPerRecord = $elapsedSeconds / $job["processed_records"];
                    $remaining = $job["total_records"] - $job["processed_records"];
                    $estimatedRemaining = (int) ($avgPerRecord * $remaining);
                }
            }

            jsonResponse([
                "status" => $job["status"],
                "total_records" => $job["total_records"],
                "processed_records" => $job["processed_records"],
                "progress_percentage" => $this->resolveJobProgressPercentage($job),
                "elapsed_seconds" => $elapsedSeconds,
                "estimated_remaining" => $estimatedRemaining,
            ]);
        } catch (ApiException $e) {
            errorResponse($e->getMessage(), $e->getStatus());
        } catch (Exception $e) {
            errorResponse("Internal Server Error", 500);
        }
    }

    private function calculateDurationSeconds($startAt, $endAt)
    {
        $startTs = strtotime((string) $startAt);
        $endTs = strtotime((string) $endAt);

        if ($startTs === false || $endTs === false) {
            return null;
        }

        return max(0, $endTs - $startTs);
    }

    private function resolveJobDurationSeconds(array $job)
    {
        if (isset($job["duration_seconds"]) && is_numeric($job["duration_seconds"])) {
            return max(0, (int) round((float) $job["duration_seconds"]));
        }

        if (!empty($job["started_at"]) && !empty($job["finished_at"])) {
            return $this->calculateDurationSeconds($job["started_at"], $job["finished_at"]);
        }

        return null;
    }

    private function resolveJobProgressPercentage(array $job)
    {
        $status = strtolower((string) ($job["status"] ?? ""));
        $total = isset($job["total_records"]) ? (int) $job["total_records"] : 0;
        $processed = isset($job["processed_records"]) ? (int) $job["processed_records"] : 0;

        if ($total > 0) {
            $computed = ($processed / $total) * 100;
            return round(min(100, max(0, $computed)), 1);
        }

        if ($status === "finished") {
            // No items to process should still be considered complete.
            return 100.0;
        }

        if (isset($job["progress_percentage"]) && is_numeric($job["progress_percentage"])) {
            return (float) $job["progress_percentage"];
        }

        return 0.0;
    }

    private function buildSyncPreviewData()
    {
        $page = 1;
        $size = 200;
        $allAuthors = [];

        while (true) {
            $result = $this->api->request("/api/v1/sinta-authors?page={$page}&size={$size}");
            $pageData = $result["data"] ?? $result;

            if (empty($pageData) || !is_array($pageData)) {
                break;
            }

            $allAuthors = array_merge($allAuthors, $pageData);

            if (count($pageData) < $size) {
                break;
            }

            $page++;
        }

        if (empty($allAuthors)) {
            return [
                "inserted" => [],
                "updated" => [],
                "stats" => ["total" => 0, "skipped" => 0],
            ];
        }

        $authorModel = $this->model("Author");
        $toInsert = [];
        $toUpdate = [];
        $skipped = 0;
        $skippedDetails = [];

        foreach ($allAuthors as $sintaAuthor) {
            $rawId = $sintaAuthor["id_sinta"] ?? null;
            $idSinta = isset($rawId) ? intval($rawId) : null;
            $fullname = (string) ($sintaAuthor["fullname"] ?? $sintaAuthor["nama"] ?? "-");

            if (!$idSinta) {
                $skipped++;
                $skippedDetails[] = [
                    "fullname" => $fullname,
                    "id_sinta" => $rawId,
                    "reason" => $rawId === null || $rawId === ""
                        ? "ID SINTA kosong (null)"
                        : "ID SINTA tidak valid (" . var_export($rawId, true) . ")",
                ];
                continue;
            }

            $localAuthor = $authorModel->getAuthorById($idSinta);

            if ($localAuthor) {
                $changed = $this->sintaFieldsChanged($localAuthor, $sintaAuthor);
                if ($changed) {
                    $changes = $this->detectAuthorFieldChanges($localAuthor, $sintaAuthor);
                    $toUpdate[] = array_merge($sintaAuthor, [
                        "id_sinta" => (int) ($localAuthor->id_sinta ?? 0),
                        "nidn" => (string) ($localAuthor->nidn ?? "-"),
                        "changes" => $changes,
                    ]);
                } else {
                    $skipped++;
                    $skippedDetails[] = [
                        "fullname" => $fullname,
                        "id_sinta" => $idSinta,
                        "reason" => "Tidak ada perubahan data",
                    ];
                }
            } else {
                $toInsert[] = $sintaAuthor;
            }
        }

        return [
            "inserted" => $toInsert,
            "updated" => $toUpdate,
            "stats" => [
                "total" => count($allAuthors),
                "skipped" => $skipped,
            ],
            "skipped_details" => $skippedDetails,
        ];
    }

    private function detectAuthorFieldChanges($local, array $incoming)
    {
        $fields = [
            "sinta_score_overall" => "SINTA Score Overall",
            "sinta_score_3yr" => "SINTA Score 3yr",
            "affil_score" => "Affiliation Score",
            "affil_score_3yr" => "Affiliation Score 3yr",
            "subject_research" => "Subject Research",
            "degree" => "Degree",
            "major" => "Major",
            "faculty" => "Faculty",
            "s_article_scopus" => "Articles (Scopus)",
            "s_citation_scopus" => "Citations (Scopus)",
            "s_cited_document_scopus" => "Cited Documents (Scopus)",
            "s_hindex_scopus" => "H-Index (Scopus)",
            "s_i10_index_scopus" => "i10-Index (Scopus)",
            "s_gindex_scopus" => "G-Index (Scopus)",
            "s_article_gscholar" => "Articles (GScholar)",
            "s_citation_gscholar" => "Citations (GScholar)",
            "s_cited_document_gscholar" => "Cited Documents (GScholar)",
            "s_hindex_gscholar" => "H-Index (GScholar)",
            "s_i10_index_gscholar" => "i10-Index (GScholar)",
            "s_gindex_gscholar" => "G-Index (GScholar)",
        ];

        $normalize = function ($val, $field) {
            if ($val === null) {
                return null;
            }

            if ($field === "degree") {
                $v = trim((string) $val);
                return $v === "" ? null : strtoupper($v);
            }

            if ($field === "major" || $field === "subject_research") {
                $v = trim((string) $val);
                $v = preg_replace('/\s+/u', ' ', $v);
                return $v === "" ? null : $v;
            }

            $v = trim((string) $val);
            return $v === "" ? null : $v;
        };

        $changes = [];

        foreach ($fields as $field => $label) {
            $oldValue = $local->{$field} ?? null;
            $newValue = $incoming[$field] ?? null;

            $nOld = $normalize($oldValue, $field);
            $nNew = $normalize($newValue, $field);

            if ($nOld !== $nNew) {
                $changes[] = [
                    "field" => $field,
                    "label" => $label,
                    "old" => $nOld,
                    "new" => $nNew,
                ];
            }
        }

        return $changes;
    }

    private function buildSyncArticlesPreviewData()
    {
        $articleModel = $this->model("Article");

        $page = 1;
        $size = 20;
        $inserted = [];
        $updated = [];
        $stats = [
            "total" => 0,
            "inserted" => 0,
            "updated" => 0,
            "skipped" => 0,
            "errors" => 0,
        ];

        while (true) {
            $apiResult = $this->api->request("/api/v1/sinta-articles?page={$page}&size={$size}");
            $rows = $this->extractRemoteArticles($apiResult);
            if (empty($rows)) {
                break;
            }

            $stats["total"] += count($rows);

            foreach ($rows as $rawArticle) {
                try {
                    $article = $this->normalizeRemoteArticle($rawArticle);
                    if ($article === null) {
                        $stats["skipped"]++;
                        continue;
                    }

                    $idSinta = isset($article["id_sinta"]) ? (int) $article["id_sinta"] : 0;
                    if ($idSinta <= 0 || !$articleModel->authorExists($idSinta)) {
                        $stats["skipped"]++;
                        continue;
                    }

                    $localArticle = $articleModel->getArticleByTitle($article["title"]);

                    if (!$localArticle) {
                        $inserted[] = [
                            "title" => $article["title"],
                            "id_sinta" => $article["id_sinta"],
                            "published" => $article["published"],
                            "journal_title" => $article["journal_title"],
                        ];
                        $stats["inserted"]++;
                        continue;
                    }

                    $changes = $this->detectArticleFieldChanges($localArticle, $article);
                    if (empty($changes)) {
                        $stats["skipped"]++;
                        continue;
                    }

                    $updated[] = [
                        "id_article" => (int) ($localArticle->id_article ?? 0),
                        "title" => $article["title"],
                        "id_sinta" => $article["id_sinta"],
                        "published" => $article["published"],
                        "changes" => $changes,
                    ];
                    $stats["updated"]++;
                } catch (Exception $e) {
                    $stats["errors"]++;
                    error_log("[buildSyncArticlesPreviewData] error: " . $e->getMessage());
                }
            }

            if (count($rows) < $size) {
                break;
            }

            $page++;
        }

        return [
            "inserted" => $inserted,
            "updated" => $updated,
            "stats" => $stats,
        ];
    }

    private function detectArticleFieldChanges($local, array $incoming)
    {
        $fields = [
            "id_sinta" => "Author ID",
            "doi" => "DOI",
            "authors" => "Authors",
            "journal_title" => "Journal",
            "short_journal_title" => "Short Journal",
            "publisher" => "Publisher",
            "issue" => "Issue",
            "volume" => "Volume",
            "page" => "Page",
            "published" => "Published",
            "type" => "Type",
            "pdf_link" => "PDF Link",
            "issn" => "ISSN",
            "issn_type" => "ISSN Type",
            "indexed_date_time" => "Indexed Date Time",
            "indexed_date_parts" => "Indexed Date",
            "url" => "URL",
        ];

        $changes = [];

        foreach ($fields as $field => $label) {
            $oldValue = $this->normalizeOptionalString($local->{$field} ?? null);
            $newValue = $this->normalizeOptionalString($incoming[$field] ?? null);

            if ($field === "id_sinta") {
                $oldValue = $oldValue === null ? null : (int) $oldValue;
                $newValue = $newValue === null ? null : (int) $newValue;
            }

            if ($oldValue !== $newValue) {
                $changes[] = [
                    "field" => $field,
                    "label" => $label,
                    "old" => $oldValue,
                    "new" => $newValue,
                ];
            }
        }

        return $changes;
    }

    private function extractRemoteArticles($apiResult)
    {
        if (isset($apiResult) && is_array($apiResult)) {
            if ($this->isListArray($apiResult)) {
                return $apiResult;
            }

            if (isset($apiResult["items"]) && is_array($apiResult["items"])) {
                return $apiResult["items"];
            }
        }

        if (isset($apiResult["items"]) && is_array($apiResult["items"])) {
            return $apiResult["items"];
        }

        return [];
    }

    private function isListArray(array $value)
    {
        $expected = 0;
        foreach ($value as $key => $_v) {
            if ($key !== $expected) {
                return false;
            }
            $expected++;
        }

        return true;
    }

    private function normalizeRemoteArticle(array $raw)
    {
        $title = $this->normalizeOptionalString($raw["title"] ?? ($raw["article_title"] ?? null));
        if ($title === null) {
            return null;
        }

        $idArticle = isset($raw["id_article"])
            ? (int) $raw["id_article"]
            : (isset($raw["id"]) ? (int) $raw["id"] : 0);

        if ($idArticle <= 0) {
            $idArticle = null;
        }

        $published = $this->normalizeOptionalString($raw["published"] ?? null);
        if ($published === null && isset($raw["year"]) && $raw["year"] !== "") {
            $published = (string) $raw["year"];
        }

        $indexedDateTime = $this->normalizeOptionalString($raw["indexed_date_time"] ?? null);
        $indexedDateParts = $this->normalizeOptionalString($raw["indexed_date_parts"] ?? null);

        return [
            "id_article" => $idArticle,
            "id_sinta" => isset($raw["id_sinta"]) ? (int) $raw["id_sinta"] : null,
            "doi" => $this->normalizeOptionalString($raw["doi"] ?? null),
            "title" => $title,
            "authors" => $this->normalizeOptionalString($raw["authors"] ?? null),
            "journal_title" => $this->normalizeOptionalString($raw["journal_title"] ?? null),
            "short_journal_title" => $this->normalizeOptionalString($raw["short_journal_title"] ?? null),
            "publisher" => $this->normalizeOptionalString($raw["publisher"] ?? null),
            "issue" => $this->normalizeOptionalString($raw["issue"] ?? null),
            "volume" => $this->normalizeOptionalString($raw["volume"] ?? null),
            "page" => $this->normalizeOptionalString($raw["page"] ?? null),
            "published" => $published,
            "type" => $this->normalizeOptionalString($raw["raw_type"] ?? null),
            "pdf_link" => $this->normalizeOptionalString($raw["pdf_link"] ?? null),
            "issn" => $this->normalizeOptionalString($raw["issn"] ?? null),
            "issn_type" => $this->normalizeOptionalString($raw["issn_type"] ?? null),
            "indexed_date_time" => $indexedDateTime,
            "indexed_date_parts" => $indexedDateParts,
            "url" => $this->normalizeOptionalString($raw["url"] ?? null),
        ];
    }

    private function normalizeOptionalString($value)
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        return $value === "" ? null : $value;
    }

    private function formatDurationFromSeconds($seconds)
    {
        $seconds = (int) $seconds;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
    }
}
