<?php

class PenelitianController extends Controller
{
  public function index()
  {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: ' . BASE_URL . 'auth/login');
      exit;
    }

    // Get current user
    $userModel = $this->model('User');
    $user = $userModel->getUserById($_SESSION['user_id']);

    // Pagination variables
    $limit = 12;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Get real data from database with pagination
    $authorModel = $this->model('Author');
    $workModel = $this->model('Work');

    $totalAuthors = $authorModel->countAuthors();
    $totalPages = ceil($totalAuthors / $limit);
    $authors = $authorModel->getAuthors($limit, $offset);

    $penelitianData = [];
    foreach ($authors as $author) {
      $penelitianData[] = [
        'id_author' => $author->id_author,
        'name' => $author->fullname,
        'nidn' => $author->nidn,
        'faculty' => $author->programs_name,
        'jumlah_jurnal' => $workModel->countWorksByAuthorId($author->id_author),
        'skor_relevansi' => $author->sinta_score_v3_overall ?? 0,
        'h_index' => $author->sinta_score_v3_3year ?? 0,
        'i10_index' => $author->affiliation_score_v3_overall ?? 0
      ];
    }

    $data = [
      'title' => 'Penelitian Dosen - UNIKOM',
      'user' => $user,
      'penelitianData' => $penelitianData,
      'totalPages' => $totalPages,
      'currentPage' => $page,
      'viewContent' => 'penelitian/index',
      'showNavbar' => true,
      'activeTab' => 'penelitian' // Used for navbar active state
    ];

    $this->view('layouts/main', $data);
  }

  public function detail($id)
  {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: ' . BASE_URL . 'auth/login');
      exit;
    }

    // Get current user
    $userModel = $this->model('User');
    $user = $userModel->getUserById($_SESSION['user_id']);

    $authorModel = $this->model('Author');
    $workModel = $this->model('Work');

    // Get detail dosen by ID (PK)
    $author = $authorModel->getAuthorById($id);

    if (!$author) {
      // Handle not found
      header('Location: ' . BASE_URL . 'penelitian');
      exit;
    }

    $works = $workModel->getWorksByAuthorId($id);
    $count = count($works);

    $ratios = $workModel->getAuthorRoleRatios($id);

    // Prepare dosen detail
    $dosenDetail = [
      'id' => $author->id_author,
      'name' => $author->fullname,
      'nidn' => $author->nidn,
      'faculty' => $author->programs_name,
      'jumlah_jurnal' => $count,
      'skor_relevansi' => $author->sinta_score_v3_overall ?? 0,
      'h_index' => $author->sinta_score_v3_3year ?? 0,
      'i10_index' => $author->affiliation_score_v3_overall ?? 0,
      'rasio_utama' => $ratios['rasio_utama'],
      'rasio_coauthor' => $ratios['rasio_coauthor']
    ];

    // Dynamic Publication Categories with Pagination
    $uniqueTypes = $workModel->getUniqueTypesByAuthor($id);
    $categorizedPublications = [];
    $pubLimit = 5;

    foreach ($uniqueTypes as $typeObj) {
      $type = $typeObj->type;
      // Sanitized key for query param (e.g., "journal-article" -> "p_journal_article")
      $paramKey = 'p_' . str_replace('-', '_', $type);
      $currentPubPage = isset($_GET[$paramKey]) ? (int) $_GET[$paramKey] : 1;
      $pubOffset = ($currentPubPage - 1) * $pubLimit;

      $totalPubs = $workModel->countWorksByTypeAndAuthor($id, $type);
      $totalPubPages = ceil($totalPubs / $pubLimit);
      $typeWorks = $workModel->getWorksByTypeAndAuthor($id, $type, $pubLimit, $pubOffset);

      $publications = [];
      foreach ($typeWorks as $work) {
        $publications[] = [
          'title' => $work->title,
          'program_studi' => $author->programs_name,
          'journal' => $work->container_title ?? '-',
          'journal_name' => $work->source ?? 'Source',
          'doi' => $work->doi ?? '-',
          'year' => $work->published,
          'type' => $work->type ?? 'Article'
        ];
      }

      $categorizedPublications[$type] = [
        'data' => $publications,
        'currentPage' => $currentPubPage,
        'totalPages' => $totalPubPages,
        'paramKey' => $paramKey,
        'totalCount' => $totalPubs
      ];
    }

    // Determine active tab (default to first type found or empty)
    $firstType = !empty($uniqueTypes) ? $uniqueTypes[0]->type : '';
    $activeTab = isset($_GET['tab']) ? $_GET['tab'] : $firstType;

    $data = [
      'title' => 'Detail Dosen - ' . $author->fullname,
      'user' => $user,
      'dosen' => $dosenDetail,
      'categorizedPublications' => $categorizedPublications,
      'activeTab' => $activeTab,
      'viewContent' => 'penelitian/detail',
      'showNavbar' => true,
      'currentPage' => 'penelitian'
    ];

    $this->view('layouts/main', $data);
  }
}
