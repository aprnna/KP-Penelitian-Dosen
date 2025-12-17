<?php

class UserController extends Controller
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
      'title' => 'Users',
      'users' => $users,
      'user' => $user,
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'user'
    ];

    $this->render('user/index', $data, 'main');
  }

  public function detail($id)
  {
    $auth = new Auth();
    $user = null;
    
    if ($auth->check()) {
      $user = $auth->user();
    }

    $detailUser = $this->userModel->getUserById($id);

    if (!$detailUser) {
      $this->redirect('user');
      return;
    }

    $data = [
      'title' => 'User Detail',
      'detailUser' => $detailUser,
      'user' => $user,
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'user'
    ];

    $this->render('user/detail', $data, 'main');
  }

  public function create()
  {
    $auth = new Auth();
    $user = null;
    
    if ($auth->check()) {
      $user = $auth->user();
    }

    $data = [
      'title' => 'Create User',
      'user' => $user,
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'user'
    ];

    $this->render('user/create', $data, 'main');
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? ''
      ];

      if ($this->userModel->createUser($data)) {
        $this->redirect('user');
      } else {
        echo "Failed to create user";
      }
    }
  }

  public function edit($id)
  {
    $auth = new Auth();
    $user = null;
    
    if ($auth->check()) {
      $user = $auth->user();
    }

    $editUser = $this->userModel->getUserById($id);

    if (!$editUser) {
      $this->redirect('user');
      return;
    }

    $data = [
      'title' => 'Edit User',
      'editUser' => $editUser,
      'user' => $user,
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'user'
    ];

    $this->render('user/edit', $data, 'main');
  }

  public function update($id)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'id' => $id,
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? ''
      ];

      if ($this->userModel->updateUser($data)) {
        $this->redirect('user');
      } else {
        echo "Failed to update user";
      }
    }
  }

  public function delete($id)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if ($this->userModel->deleteUser($id)) {
        $this->redirect('user');
      } else {
        echo "Failed to delete user";
      }
    }
  }
}
