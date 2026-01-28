<?php

class ScrapingController extends Controller
{
  private $auth;
  private $apiBaseUrl;
  private $apiKey;

  public function __construct()
  {
    $this->auth = new Auth();
    // Check if user is authenticated
    if (!$this->auth->check()) {
      $this->redirect('auth/login');
      return;
    }

    $this->apiBaseUrl = rtrim(str_replace('/api/v1/scrape', '', API_URL), '/');
    $this->apiKey = API_KEY;
  }

  // Display scraping dashboard
  public function index()
  {
    $data = [
      'title' => 'Scraping Dashboard',
      'user' => $this->auth->user(),
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'scraping'
    ];

    $this->render('scraping/index', $data, 'main');
  }

  // Helper: Make API request to FastAPI
  private function apiRequest($endpoint, $method = 'GET', $data = null)
  {
    $ch = curl_init($this->apiBaseUrl . $endpoint);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
      'X-API-Key: ' . $this->apiKey
    ]);

    if ($method === 'POST') {
      curl_setopt($ch, CURLOPT_POST, true);
      if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      }
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
      return ['success' => false, 'error' => $error, 'http_code' => $httpCode];
    }

    $decoded = json_decode($response, true);
    return ['success' => $httpCode >= 200 && $httpCode < 300, 'data' => $decoded, 'http_code' => $httpCode];
  }

  // API: Get jobs list with pagination and filters
  public function getJobs()
  {
    header('Content-Type: application/json');

    $params = [];
    if (!empty($_GET['status'])) {
      $params['status'] = $_GET['status'];
    }
    if (!empty($_GET['limit'])) {
      $params['limit'] = (int) $_GET['limit'];
    } else {
      $params['limit'] = 20;
    }
    if (!empty($_GET['page'])) {
      $page = (int) $_GET['page'];
      $params['offset'] = ($page - 1) * $params['limit'];
    }

    $queryString = http_build_query($params);
    $result = $this->apiRequest('/api/v1/jobs?' . $queryString);

    if (!$result['success']) {
      echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch jobs',
        'error' => $result['error'] ?? 'Unknown error'
      ]);
      exit;
    }

    $apiData = $result['data'];

    // Transform FastAPI response to match frontend expectations
    echo json_encode([
      'success' => true,
      'data' => $apiData['jobs'] ?? [],
      'pagination' => [
        'total' => $apiData['total'] ?? 0,
        'page' => isset($_GET['page']) ? (int) $_GET['page'] : 1,
        'limit' => $params['limit'],
        'total_pages' => ceil(($apiData['total'] ?? 0) / $params['limit'])
      ]
    ]);
    exit;
  }

  // API: Get job details
  public function getJobDetails($jobUuid)
  {
    header('Content-Type: application/json');

    $result = $this->apiRequest('/api/v1/jobs/' . $jobUuid);

    if (!$result['success']) {
      echo json_encode([
        'success' => false,
        'message' => 'Job not found'
      ]);
      exit;
    }

    $apiData = $result['data'];
    $job = $apiData['job'] ?? null;
    $logs = $apiData['logs'] ?? [];

    if (!$job) {
      echo json_encode(['success' => false, 'message' => 'Job not found']);
      exit;
    }

    // Count logs by level
    $logCounts = ['DEBUG' => 0, 'INFO' => 0, 'WARNING' => 0, 'ERROR' => 0];
    foreach ($logs as $log) {
      $level = strtoupper($log['level'] ?? 'INFO');
      if (isset($logCounts[$level])) {
        $logCounts[$level]++;
      }
    }

    // Calculate duration
    $duration = null;
    if (!empty($job['started_at']) && !empty($job['finished_at'])) {
      $start = new DateTime($job['started_at']);
      $end = new DateTime($job['finished_at']);
      $interval = $end->diff($start);
      $duration = $interval->format('%H:%I:%S');
    }

    echo json_encode([
      'success' => true,
      'data' => [
        'job' => $job,
        'duration' => $duration,
        'progress_percentage' => $job['progress_percentage'] ?? 0,
        'log_counts' => $logCounts,
        'is_running' => $job['status'] === 'running',
        'is_finished' => $job['status'] === 'finished',
        'is_failed' => $job['status'] === 'failed'
      ]
    ]);
    exit;
  }

  // API: Get job progress (for polling)
  public function getJobProgress($jobUuid)
  {
    header('Content-Type: application/json');

    $result = $this->apiRequest('/api/v1/jobs/' . $jobUuid);

    if (!$result['success']) {
      echo json_encode([
        'success' => false,
        'message' => 'Job not found'
      ]);
      exit;
    }

    $job = $result['data']['job'] ?? null;

    if (!$job) {
      echo json_encode(['success' => false, 'message' => 'Job not found']);
      exit;
    }

    // Calculate elapsed time
    $elapsedSeconds = 0;
    $estimatedRemaining = null;

    if (!empty($job['started_at'])) {
      $start = new DateTime($job['started_at']);
      $now = new DateTime();
      $elapsed = $now->diff($start);
      $elapsedSeconds = ($elapsed->days * 86400) + ($elapsed->h * 3600) + ($elapsed->i * 60) + $elapsed->s;

      // Estimate remaining time
      if ($job['processed_records'] > 0 && $job['total_records'] > 0) {
        $avgTimePerRecord = $elapsedSeconds / $job['processed_records'];
        $remainingRecords = $job['total_records'] - $job['processed_records'];
        $estimatedRemaining = (int) ($avgTimePerRecord * $remainingRecords);
      }
    }

    echo json_encode([
      'success' => true,
      'data' => [
        'status' => $job['status'],
        'total_records' => $job['total_records'],
        'processed_records' => $job['processed_records'],
        'progress_percentage' => $job['progress_percentage'],
        'elapsed_seconds' => $elapsedSeconds,
        'estimated_remaining' => $estimatedRemaining
      ]
    ]);
    exit;
  }

  // API: Get logs for a job
  public function getLogs($jobUuid)
  {
    header('Content-Type: application/json');

    $params = [];
    if (!empty($_GET['level'])) {
      $params['level'] = strtoupper($_GET['level']);
    }
    if (!empty($_GET['limit'])) {
      $params['limit'] = (int) $_GET['limit'];
    } else {
      $params['limit'] = 50;
    }

    $queryString = http_build_query($params);
    $result = $this->apiRequest('/api/v1/jobs/' . $jobUuid . '/logs?' . $queryString);

    if (!$result['success']) {
      echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch logs',
        'data' => []
      ]);
      exit;
    }

    $logs = $result['data'] ?? [];

    // Filter logs by since_id if provided (client-side filtering for real-time updates)
    $sinceId = isset($_GET['since_id']) ? (int) $_GET['since_id'] : 0;
    if ($sinceId > 0) {
      $logs = array_filter($logs, function ($log) use ($sinceId) {
        return $log['id'] > $sinceId;
      });
      $logs = array_values($logs); // Re-index array
    }

    echo json_encode([
      'success' => true,
      'data' => $logs
    ]);
    exit;
  }

  // API: Trigger scraping
  public function triggerScraping()
  {
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      echo json_encode(['success' => false, 'message' => 'Method not allowed']);
      exit;
    }

    // Call FastAPI to create and start job
    $result = $this->apiRequest('/api/v1/scrape', 'POST', ['source' => 'CROSSREF', 'year_start' => 2023, 'year_end' => 2024, 'authors' => ['Dian Dharmayanti']]);

    if (!$result['success']) {
      echo json_encode([
        'success' => false,
        'message' => 'Failed to trigger scraping API',
        'error' => $result['error'] ?? 'HTTP ' . $result['http_code']
      ]);
      exit;
    }

    $apiResponse = $result['data'];

    if (!isset($apiResponse['job_id'])) {
      echo json_encode([
        'success' => false,
        'message' => 'Invalid API response'
      ]);
      exit;
    }

    echo json_encode([
      'success' => true,
      'message' => $apiResponse['message'] ?? 'Scraping job started',
      'job_id' => $apiResponse['job_id']
    ]);
    exit;
  }
}
