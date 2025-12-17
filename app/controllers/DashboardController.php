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

    $data = [
      'title' => 'Dashboard',
      'users' => $users,
      'user' => $user,
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'dashboard'
    ];

    $this->render('dashboard/index', $data, 'main');
  }
}
