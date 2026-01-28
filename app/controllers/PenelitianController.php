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
    $faculty = isset($_GET['faculty']) ? $_GET['faculty'] : null;
    $search = isset($_GET['search']) ? $_GET['search'] : null;
    $offset = ($page - 1) * $limit;

    // Get real data from database with pagination
    $authorModel = $this->model('Author');
    $articleModel = $this->model('Article');

    $totalAuthors = $authorModel->countAuthors($faculty, $search);
    $totalPages = ceil($totalAuthors / $limit);
    $authors = $authorModel->getAuthors($limit, $offset, $faculty, $search);
    $faculties = $authorModel->getUniqueFaculties();

    $penelitianData = [];
    foreach ($authors as $author) {
      $penelitianData[] = [
        'id_sinta' => $author->id_sinta,
        'name' => $author->fullname,
        'nidn' => $author->nidn,
        'faculty' => $author->faculty,
        'jumlah_jurnal' => $articleModel->countArticlesByAuthorId($author->id_sinta),
        'sinta_score' => $author->sinta_score_overall ?? 0,
        'sinta_score_3yr' => $author->sinta_score_3yr ?? 0,
        'affil_score' => $author->affil_score ?? 0,
        'affil_score_3yr' => $author->affil_score_3yr ?? 0,
        'scopus_h_index' => $author->s_hindex_scopus ?? 0,
        'gs_h_index' => $author->s_hindex_gscholar ?? 0
      ];
    }

    $data = [
      'title' => 'Penelitian Dosen - UNIKOM',
      'user' => $user,
      'penelitianData' => $penelitianData,
      'totalPages' => $totalPages,
      'currentPage' => $page,
      'faculty' => $faculty,
      'search' => $search,
      'viewContent' => 'penelitian/index',
      'faculties' => $faculties,
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
    $articleModel = $this->model('Article');

    // Get detail dosen by ID (PK)
    $author = $authorModel->getAuthorById($id);

    if (!$author) {
      // Handle not found
      header('Location: ' . BASE_URL . 'penelitian');
      exit;
    }

    $articles = $articleModel->getArticlesByAuthorId($id);
    $count = count($articles);

    $ratios = $articleModel->getAuthorRoleRatios($id);

    // Prepare dosen detail
    $dosenDetail = [
      'id' => $author->id_sinta,
      'name' => $author->fullname,
      'nidn' => $author->nidn,
      'faculty' => $author->faculty,
      'jumlah_jurnal' => $count,
      'sinta_score' => $author->sinta_score_overall ?? 0,
      'sinta_score_3yr' => $author->sinta_score_3yr ?? 0,
      'affil_score' => $author->affil_score ?? 0,
      'affil_score_3yr' => $author->affil_score_3yr ?? 0,
      'scopus_h_index' => $author->s_hindex_scopus ?? 0,
      'gs_h_index' => $author->s_hindex_gscholar ?? 0,
      'subject_research' => $author->subject_research ?? 'Research & Publications',
      'rasio_utama' => $ratios['rasio_utama'],
      'rasio_coauthor' => $ratios['rasio_coauthor']
    ];

    // Dynamic Publication Categories with Pagination
    $uniqueTypes = $articleModel->getUniqueTypesByAuthor($id);
    $categorizedPublications = [];
    $pubLimit = 5;

    foreach ($uniqueTypes as $typeObj) {
      $type = $typeObj->type;
      // Sanitized key for query param (e.g., "journal-article" -> "p_journal_article")
      $paramKey = 'p_' . str_replace('-', '_', $type);
      $currentPubPage = isset($_GET[$paramKey]) ? (int) $_GET[$paramKey] : 1;
      $pubOffset = ($currentPubPage - 1) * $pubLimit;

      $totalPubs = $articleModel->countArticlesByTypeAndAuthor($id, $type);
      $totalPubPages = ceil($totalPubs / $pubLimit);
      $typeArticles = $articleModel->getArticlesByTypeAndAuthor($id, $type, $pubLimit, $pubOffset);

      $publications = [];
      foreach ($typeArticles as $article) {
        $publications[] = [
          'title' => $article->title,
          'program_studi' => $author->faculty,
          'journal' => $article->journal_title ?? '-',
          'journal_name' => $article->source ?? 'Source',
          'doi' => $article->doi ?? '-',
          'year' => $article->published,
          'type' => $article->type ?? 'Article'
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
