<?php

class HomeController extends Controller
{

  public function index()
  {
    $data = [
      'title' => 'Home Page',
      'message' => 'Welcome to MVC Framework'
    ];

    $this->view('home/index', $data);
  }
}
