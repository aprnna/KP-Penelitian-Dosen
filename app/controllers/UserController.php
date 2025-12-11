<?php
// app/controllers/UserController.php

class UserController extends Controller
{

  private $userModel;

  public function __construct()
  {
    $this->userModel = $this->model('User');
  }

  public function index()
  {
    $users = $this->userModel->getAllUsers();

    $data = [
      'title' => 'Users',
      'users' => $users
    ];

    $this->view('user/index', $data);
  }

  public function detail($id)
  {
    $user = $this->userModel->getUserById($id);

    if (!$user) {
      $this->redirect('user');
      return;
    }

    $data = [
      'title' => 'User Detail',
      'user' => $user
    ];

    $this->view('user/detail', $data);
  }

  public function create()
  {
    $data = [
      'title' => 'Create User'
    ];

    $this->view('user/create', $data);
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
    $user = $this->userModel->getUserById($id);

    if (!$user) {
      $this->redirect('user');
      return;
    }

    $data = [
      'title' => 'Edit User',
      'user' => $user
    ];

    $this->view('user/edit', $data);
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
