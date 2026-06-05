<?php

require_once '../app/services/ReportingPdfService.php';

class ReportingController extends Controller
{
  private $auth;

  public function __construct()
  {
    require_once '../app/middleware/AuthMiddleware.php';
    AuthMiddleware::handle();

    $this->auth = new Auth();
  }

  public function index()
  {
    $startYear = isset($_GET['start_year']) ? trim((string) $_GET['start_year']) : '';
    $endYear = isset($_GET['end_year']) ? trim((string) $_GET['end_year']) : '';
    $error = isset($_GET['error']) ? trim((string) $_GET['error']) : '';

    $articles = [];
    $hasFilter = ($startYear !== '' || $endYear !== '');

    if ($hasFilter && $error === '') {
      if ($startYear === '' || $endYear === '') {
        $error = 'Tahun start dan end wajib diisi.';
      } elseif (!$this->isValidYear($startYear) || !$this->isValidYear($endYear)) {
        $error = 'Format tahun tidak valid. Gunakan format YYYY.';
      } elseif ((int) $startYear > (int) $endYear) {
        $error = 'Tahun start tidak boleh lebih besar dari tahun end.';
      } else {
        $articleModel = $this->model('Article');
        $articles = $articleModel->getArticlesForReporting((int) $startYear, (int) $endYear);
      }
    }

    $data = [
      'title' => 'Reporting Artikel',
      'user' => $this->auth->user(),
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'reporting',
      'startYear' => $startYear,
      'endYear' => $endYear,
      'errorMessage' => $error,
      'articles' => $articles,
      'hasFilter' => $hasFilter,
    ];

    $this->render('reporting/index', $data, 'main');
  }

  public function exportPdf()
  {
    $startYear = isset($_GET['start_year']) ? trim((string) $_GET['start_year']) : '';
    $endYear = isset($_GET['end_year']) ? trim((string) $_GET['end_year']) : '';

    if ($startYear === '' || $endYear === '') {
      $this->redirectWithError('Tahun start dan end wajib diisi.');
    }

    if (!$this->isValidYear($startYear) || !$this->isValidYear($endYear)) {
      $this->redirectWithError('Format tahun tidak valid. Gunakan format YYYY.');
    }

    if ((int) $startYear > (int) $endYear) {
      $this->redirectWithError('Tahun start tidak boleh lebih besar dari tahun end.');
    }

    $articleModel = $this->model('Article');
    $articles = $articleModel->getArticlesForReporting((int) $startYear, (int) $endYear);

    $pdfService = new ReportingPdfService();
    $pdfService->download($articles, $startYear, $endYear);
  }

  private function isValidYear($value)
  {
    return preg_match('/^\d{4}$/', (string) $value) === 1;
  }

  private function redirectWithError($message)
  {
    $query = http_build_query([
      'start_year' => isset($_GET['start_year']) ? $_GET['start_year'] : '',
      'end_year' => isset($_GET['end_year']) ? $_GET['end_year'] : '',
      'error' => $message,
    ]);

    header('Location: ' . BASE_URL . 'reporting?' . $query);
    exit;
  }
}
