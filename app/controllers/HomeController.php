<?php

class HomeController extends Controller
{

  public function index()
  {
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
