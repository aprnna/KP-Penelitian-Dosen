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
    if ($auth->check()) {
      // Get user object
      $user = $auth->user();
      echo $user->full_name;
    }
    $users = $this->userModel->getAllUsers();

    $data = [
      'title' => 'Dashboard',
      'users' => $users,
      'user' => $user
    ];

    $this->view('dashboard/index', $data);
  }
}
