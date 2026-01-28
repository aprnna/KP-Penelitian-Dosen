<?php

class DashboardController extends Controller
{
  private $userModel;

  public function __construct()
  {
    require_once '../app/middleware/AuthMiddleware.php';
    AuthMiddleware::handle();

    $this->userModel = $this->model('User');
  }

  public function index()
  {
    $auth = new Auth();
    $user = null;

    if ($auth->check()) {
      $user = $auth->user();
    }

    $users = $this->userModel->getAllUsers();

    // Models
    $authorModel = $this->model('Author');
    $articleModel = $this->model('Article');

    // Real data for dashboard - default to current year
    $currentYear = date('Y');
    $statsData = [
      'total_dosen' => $authorModel->countAuthors(),
      'total_publikasi' => $articleModel->countTotalArticles($currentYear),
      'total_terindeksasi' => $articleModel->countIndexedArticles($currentYear)
    ];

    // Filter Parameters for Ranked List (Default to current year)
    $rankFaculty = $_GET['rank_faculty'] ?? 'Semua Fakultas';
    $rankYear = $_GET['rank_year'] ?? date('Y');

    // Get Filtered Top Authors (Ranked List)
    // Note: User requested "jumlah publikasi jurnal terindeks terbanyak"
    $topAuthors = $authorModel->getTopAuthorsByPublicationCount(10, $rankFaculty, $rankYear);

    $topDosenList = [];
    $rank = 1;

    foreach ($topAuthors as $author) {
      $badgeClass = 'bg-secondary';
      $badgeIcon = '';

      if ($rank == 1) {
        $badgeClass = 'bg-warning text-white';
        $badgeIcon = 'MedalGold.png';
      }
      if ($rank == 2) {
        $badgeClass = 'bg-success text-white';
        $badgeIcon = 'MedalSilver.png';
      }
      if ($rank == 3) {
        $badgeClass = 'bg-info text-white';
        $badgeIcon = 'MedalBronze.png';
      }


      $topDosenList[] = [
        'rank' => $rank++,
        'name' => $author->fullname,
        'faculty' => $author->faculty,
        'nidn' => $author->nidn,
        'publications' => $author->pub_count,
        'detail' => 'Sinta Score Overall: ' . $author->sinta_score_overall,
        'badge_class' => $badgeClass,
        'badge_icon' => $badgeIcon
      ];
    }

    $chartData = $this->getChartData();
    $faculties = $authorModel->getUniqueFaculties();

    $data = [
      'title' => 'Dashboard',
      'users' => $users,
      'user' => $user,
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'dashboard',
      'stats' => $statsData,
      'topDosen' => $topDosenList,
      'charts' => $chartData,
      'faculties' => $faculties
    ];

    $this->render('dashboard/index', $data, 'main');
  }



  private function getChartData()
  {
    $authorModel = $this->model('Author');
    $articleModel = $this->model('Article');

    // 1. Productivity Trend (New Logic: Top 5 by Count in Last 5 Years)
    $currentYear = (int) date('Y');
    $startYear = $currentYear - 4;
    $topTrendAuthors = $authorModel->getTopAuthorsByRangeCount(5, $startYear, $currentYear, null);
    $productivityData = [];
    $allYears = [];

    // Build X-axis for last 5 years
    for ($y = $startYear; $y <= $currentYear; $y++) {
      $allYears[] = (string) $y;
    }

    // Get metrics for these top authors
    $authorMetrics = [];
    foreach ($topTrendAuthors as $author) {
      $metrics = $articleModel->getProductivityTrend($author->id_sinta);
      $authorMetrics[$author->id_sinta] = $metrics;
    }

    foreach ($topTrendAuthors as $author) {
      $metrics = $authorMetrics[$author->id_sinta] ?? [];
      $countsByYear = [];
      foreach ($metrics as $m) {
        $countsByYear[$m->year] = $m->count;
      }

      $dataSequence = [];
      foreach ($allYears as $year) {
        $dataSequence[] = $countsByYear[$year] ?? 0;
      }

      $productivityData[] = [
        'label' => $author->fullname,
        'data' => $dataSequence
      ];
    }


    // 2. Faculty Distribution (Default: this Year)
    $facultyStats = $authorModel->getFacultyPublicationStats(date('Y'));
    $treemapData = [];
    foreach ($facultyStats as $stat) {
      $treemapData[] = [
        'name' => $stat->faculty,
        'value' => $stat->total_publications
      ];
    }

    // 3. Top Journals (Default: this Year)
    $topJournals = $articleModel->getTopJournals(5, null, date('Y'));
    $barChart1 = [
      'labels' => [],
      'data' => []
    ];
    foreach ($topJournals as $j) {
      $barChart1['labels'][] = $j->journal_name;
      $barChart1['data'][] = $j->total;
    }

    // 4. Publication Type Trend (5 Years)
    $currentYear = (int) date('Y');
    $startYear = $currentYear - 4;
    $typeStats = $articleModel->getArticleTypeStats($startYear, $currentYear, null); // null faculty

    $types = [];
    $typeDataRaw = [];
    $allYears = [];
    for ($y = $startYear; $y <= date('Y'); $y++)
      $allYears[] = (string) $y;

    foreach ($typeStats as $ts) {
      if (!in_array($ts->type, $types))
        $types[] = $ts->type;

      $typeDataRaw[$ts->type][$ts->year] = $ts->count;
    }

    $typeChart = [
      'labels' => $allYears,
      'datasets' => []
    ];

    foreach ($types as $type) {
      $data = [];
      foreach ($allYears as $year) {
        $data[] = $typeDataRaw[$type][$year] ?? 0;
      }
      $typeChart['datasets'][] = [
        'label' => $type,
        'data' => $data
      ];
    }

    // 5. Top Impact Authors (New Chart)
    $topImpactAuthors = $authorModel->getTopAuthorsByFaculty(null, null, 5); // Default All Faculties, All Years
    $impactChart = [
      'labels' => [],
      'data' => []
    ];
    foreach ($topImpactAuthors as $author) {
      $impactChart['labels'][] = $author->fullname;
      $impactChart['data'][] = $author->sinta_score_overall;
    }

    return [
      'productivity' => [
        'years' => $allYears,
        'datasets' => $productivityData
      ],
      'treemap' => $treemapData,
      'bar1' => $barChart1, // Top Journals
      'impact' => $impactChart,
      'pubType' => $typeChart
    ];
  }

  // API Endpoint for AJAX Filters
  public function filterData()
  {
    header('Content-Type: application/json');

    $type = $_GET['type'] ?? '';
    $faculty = $_GET['faculty'] ?? null;
    $year = $_GET['year'] ?? null; // Default null (All Years) from JS empty string

    if ($faculty === 'Semua Fakultas')
      $faculty = null;

    $authorModel = $this->model('Author');
    $articleModel = $this->model('Article');

    if ($type === 'ranked_list') {
      // Allow year filter
      $topAuthors = $authorModel->getTopAuthorsByPublicationCount(10, $faculty, $year);

      // Render HTML using component
      ob_start();
      $rank = 1;
      foreach ($topAuthors as $index => $author) {
        $badgeClass = 'bg-secondary';
        $badgeIcon = '';
        if ($rank == 1) {
          $badgeClass = 'bg-warning text-white';
          $badgeIcon = 'MedalGold.png';
        } elseif ($rank == 2) {
          $badgeClass = 'bg-success text-white';
          $badgeIcon = 'MedalSilver.png';
        } elseif ($rank == 3) {
          $badgeClass = 'bg-info text-white';
          $badgeIcon = 'MedalBronze.png';
        }


        $name = $author->fullname;
        $faculty = $author->faculty;
        $nidn = $author->nidn;
        $publications = $author->pub_count;
        $detail = 'Sinta Score Overall: ' . $author->sinta_score_overall;
        $badge_class = $badgeClass;
        $badge_icon = $badgeIcon;
        $isAlternate = $index % 2 == 1;

        include '../app/views/components/ranked_list_item.php';
        $rank++;
      }
      $html = ob_get_clean();

      echo json_encode(['html' => $html]);
      exit;
    }

    if ($type === 'productivity') {
      $productivityData = [];
      $allYears = [];

      // Logic: Top 5 by Count in Range
      // Year from filter or Current Year
      $endYear = $year ? (int) $year : (int) date('Y');
      $startYear = $endYear - 4;

      $topTrendAuthors = $authorModel->getTopAuthorsByRangeCount(5, $startYear, $endYear, $faculty);
      $authorMetrics = [];

      // Build X-axis
      for ($y = $startYear; $y <= $endYear; $y++) {
        $allYears[] = (string) $y;
      }

      foreach ($topTrendAuthors as $author) {
        $metrics = $articleModel->getProductivityTrend($author->id_sinta);
        $authorMetrics[$author->id_sinta] = $metrics;
      }

      foreach ($topTrendAuthors as $author) {
        $metrics = $authorMetrics[$author->id_sinta] ?? [];
        $countsByYear = [];
        foreach ($metrics as $m)
          $countsByYear[$m->year] = $m->count;

        $dataSequence = [];
        foreach ($allYears as $yy)
          $dataSequence[] = $countsByYear[$yy] ?? 0;

        $productivityData[] = [
          'label' => $author->fullname,
          'data' => $dataSequence
        ];
      }

      echo json_encode(['years' => $allYears, 'datasets' => $productivityData]);
      exit;
    }

    if ($type === 'treemap') {
      // Faculty Distribution filtered by Year
      if (empty($year)) {
        $year = null;
      }
      $facultyStats = $authorModel->getFacultyPublicationStats($year);
      $treemapData = [];
      $totalPubs = 0;
      foreach ($facultyStats as $stat)
        $totalPubs += $stat->total_publications;

      foreach ($facultyStats as $stat) {
        $percentage = $totalPubs > 0 ? round(($stat->total_publications / $totalPubs) * 100, 1) : 0;
        $treemapData[] = [
          'name' => $stat->faculty,
          'value' => $stat->total_publications,
          'percentage' => $percentage
        ];
      }
      echo json_encode(['data' => $treemapData]);
      exit;
    }

    if ($type === 'pub_type') {
      $endYear = $year ? (int) $year : (int) date('Y');
      $startYear = $endYear - 4;
      $typeStats = $articleModel->getArticleTypeStats($startYear, $endYear, $faculty);

      $types = [];
      $typeDataRaw = [];
      $allYears = [];
      for ($y = $startYear; $y <= $endYear; $y++)
        $allYears[] = (string) $y;

      foreach ($typeStats as $ts) {
        if (!in_array($ts->type, $types))
          $types[] = $ts->type;
        $typeDataRaw[$ts->type][$ts->year] = $ts->count;
      }

      $datasets = [];
      foreach ($types as $type) {
        $data = [];
        foreach ($allYears as $y)
          $data[] = $typeDataRaw[$type][$y] ?? 0;
        $datasets[] = ['label' => $type, 'data' => $data];
      }

      echo json_encode(['labels' => $allYears, 'datasets' => $datasets]);
      exit;
    }

    if ($type === 'top_journals') {
      // Top 5 Journals (Null = All Years)
      $targetYear = $year ?: null;
      $topJournals = $articleModel->getTopJournals(5, $faculty, $targetYear);

      $labels = [];
      $data = [];
      foreach ($topJournals as $j) {
        $labels[] = $j->journal_name;
        $data[] = $j->total;
      }
      echo json_encode(['labels' => $labels, 'data' => $data]);
      exit;
    }

    if ($type === 'top_impact') {
      $topAuthors = $authorModel->getTopAuthorsByFaculty($faculty, $year, 5);
      $labels = [];
      $data = [];
      foreach ($topAuthors as $a) {
        $labels[] = $a->fullname;
        $data[] = $a->sinta_score_overall;
      }
      echo json_encode(['labels' => $labels, 'data' => $data]);
      exit;
    }
    if ($type === 'stats') {
      $faculty = $_GET['faculty'] ?? null;
      $year = $_GET['year'] ?? null;

      if ($faculty === 'Semua Fakultas')
        $faculty = null;

      if (empty($year)) {
        $year = null;
      }

      $totalDosen = $authorModel->countAuthors($faculty);
      $totalPublikasi = $articleModel->countTotalArticles($year, $faculty);
      $totalTerindeksasi = $articleModel->countIndexedArticles($year, $faculty);

      echo json_encode([
        'total_dosen' => $totalDosen,
        'total_publikasi' => $totalPublikasi,
        'total_terindeksasi' => $totalTerindeksasi
      ]);
      exit;
    }
  }
}