<?php

class HomeController extends Controller
{
  private $auth;

  public function __construct()
  {
    $this->auth = new Auth();
  }

  public function index()
  {
    if ($this->auth->check()) {
      $this->redirect('dashboard');
      return;
    }

    $data = [
      'title' => 'Home Page',
      'message' => 'Welcome to MVC Framework',
      'showNavbar' => true,
      'showFooter' => true,
      'currentPage' => 'home'
    ];

    $this->render('home/index', $data, 'main');
  }
}
