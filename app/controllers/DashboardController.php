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
    $workModel = $this->model('Work');

    // Real data for dashboard
    $statsData = [
      'total_dosen' => $authorModel->countAuthors(),
      'total_publikasi' => $workModel->countTotalWorks(),
      'total_terindeksasi' => $workModel->countIndexedWorks()
    ];

    // Filter Parameters for Ranked List (Default)
    $rankFaculty = $_GET['rank_faculty'] ?? 'Semua Fakultas';

    // Get Filtered Top Authors (Ranked List)
    // Note: User requested "jumlah publikasi jurnal terindeks terbanyak"
    $topAuthors = $authorModel->getTopAuthorsByPublicationCount(10, $rankFaculty);

    $topDosenList = [];
    $rank = 1;

    foreach ($topAuthors as $author) {
      $badgeClass = 'bg-secondary';
      $badgeIcon = '';

      if ($rank == 1) {
        $badgeClass = 'bg-warning text-white';
        $badgeIcon = 'bi-trophy-fill';
      }
      if ($rank == 2) {
        $badgeClass = 'bg-success text-white';
        $badgeIcon = 'bi-trophy-fill';
      }
      if ($rank == 3) {
        $badgeClass = 'bg-info text-white';
        $badgeIcon = 'bi-trophy-fill';
      }


      $topDosenList[] = [
        'rank' => $rank++,
        'name' => $author->fullname,
        'faculty' => $author->programs_name,
        'nidn' => $author->nidn,
        'publications' => $author->pub_count,
        'detail' => 'Sinta Score: ' . $author->sinta_score_v3_overall,
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
    $workModel = $this->model('Work');

    // 1. Productivity Trend (Logic: Growth based to find most increased trend)
    $currentYear = (int) date('Y');
    $topGrowthAuthors = $authorModel->getTopAuthorsByGrowth(5, $currentYear - 2, $currentYear, null);
    $productivityData = [];
    $allYears = [];
    $minYear = 9999;
    $maxYear = 0;

    // First pass to find min/max years across all top authors
    $authorMetrics = [];
    foreach ($topGrowthAuthors as $author) {
      $metrics = $workModel->getProductivityTrend($author->id_author);
      $authorMetrics[$author->id_author] = $metrics;
      foreach ($metrics as $m) {
        if ($m->year < $minYear)
          $minYear = (int) $m->year;
        if ($m->year > $maxYear)
          $maxYear = (int) $m->year;
      }
    }

    // If no data, fallback
    if ($minYear == 9999) {
      $minYear = date('Y') - 4;
      $maxYear = date('Y');
    }

    // Build X-axis
    for ($y = $minYear; $y <= $maxYear; $y++) {
      $allYears[] = (string) $y;
    }

    foreach ($topGrowthAuthors as $author) {
      $metrics = $authorMetrics[$author->id_author] ?? [];
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


    // 2. Faculty Distribution (Default: All Years)
    $facultyStats = $authorModel->getFacultyPublicationStats(null); // Pass null for all years
    $treemapData = [];
    foreach ($facultyStats as $stat) {
      $treemapData[] = [
        'name' => $stat->faculty,
        'value' => $stat->total_publications
      ];
    }

    // 3. Top Journals (Default: All Years)
    $topJournals = $workModel->getTopJournals(5, null, null);
    $barChart1 = [
      'labels' => [],
      'data' => []
    ];
    foreach ($topJournals as $j) {
      $barChart1['labels'][] = $j->journal_name;
      $barChart1['data'][] = $j->total;
    }

    // 4. Publication Type Trend (5 Years)
    $startYear = date('Y') - 4;
    $typeStats = $workModel->getWorkTypeStats($startYear, null); // null faculty

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
    $topImpactAuthors = $authorModel->getTopAuthorsByFaculty(null, 5); // Default All Faculties
    $impactChart = [
      'labels' => [],
      'data' => []
    ];
    foreach ($topImpactAuthors as $author) {
      $impactChart['labels'][] = $author->fullname;
      $impactChart['data'][] = $author->sinta_score_v3_overall;
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
    $workModel = $this->model('Work');

    if ($type === 'ranked_list') {
      $topAuthors = $authorModel->getTopAuthorsByPublicationCount(10, $faculty);
      $data = [];
      $rank = 1;
      foreach ($topAuthors as $author) {
        $badgeClass = 'bg-secondary';
        $badgeIcon = '';
        if ($rank == 1) {
          $badgeClass = 'bg-warning text-white';
          $badgeIcon = 'bi-trophy-fill';
        } elseif ($rank == 2) {
          $badgeClass = 'bg-success text-white';
          $badgeIcon = 'bi-trophy-fill';
        } elseif ($rank == 3) {
          $badgeClass = 'bg-info text-white';
          $badgeIcon = 'bi-trophy-fill';
        }
        $data[] = [
          'rank' => $rank++,
          'name' => $author->fullname,
          'faculty' => $author->programs_name,
          'nidn' => $author->nidn,
          'publications' => $author->pub_count,
          'detail' => 'Sinta Score: ' . $author->sinta_score_v3_overall,
          'badge_class' => $badgeClass,
          'badge_icon' => $badgeIcon
        ];
      }
      echo json_encode(['data' => $data]);
      exit;
    }

    if ($type === 'productivity') {
      $productivityData = [];
      $allYears = [];

      // Logic: Top 5 by Growth (Baseline 2 years)
      $currentYear = (int) date('Y');
      $topGrowthAuthors = $authorModel->getTopAuthorsByGrowth(5, $currentYear - 2, $currentYear, $faculty);

      $minYear = 9999;
      $maxYear = 0;
      $authorMetrics = [];

      foreach ($topGrowthAuthors as $author) {
        $metrics = $workModel->getProductivityTrend($author->id_author);
        // Only count valid metrics
        $validMetrics = [];
        foreach ($metrics as $m) {
          if ($m->year > 0) { // filter out 0 or null years if any
            $validMetrics[] = $m;
            if ($m->year < $minYear)
              $minYear = (int) $m->year;
            if ($m->year > $maxYear)
              $maxYear = (int) $m->year;
          }
        }
        $authorMetrics[$author->id_author] = $validMetrics;
      }
      if ($minYear == 9999) {
        $minYear = date('Y') - 4;
        $maxYear = date('Y');
      }

      for ($y = $minYear; $y <= $maxYear; $y++)
        $allYears[] = (string) $y;

      foreach ($topGrowthAuthors as $author) {
        $metrics = $authorMetrics[$author->id_author] ?? [];
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
      $startYear = date('Y') - 4;
      $typeStats = $workModel->getWorkTypeStats($startYear, $faculty);

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
      $topJournals = $workModel->getTopJournals(5, $faculty, $targetYear);

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
      $topAuthors = $authorModel->getTopAuthorsByFaculty($faculty, 5);
      $labels = [];
      $data = [];
      foreach ($topAuthors as $a) {
        $labels[] = $a->fullname;
        $data[] = $a->sinta_score_v3_overall;
      }
      echo json_encode(['labels' => $labels, 'data' => $data]);
      exit;
    }
  }
}