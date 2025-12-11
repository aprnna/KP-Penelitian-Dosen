<?php
// app/core/App.php

class App
{
  protected $router;

  public function __construct()
  {
    $this->router = new Router();

    // Load routes - pass $router variable to routes file
    $router = $this->router;
    require_once '../routes/web.php';

    // Dispatch
    $uri = $this->router->getCurrentUri();
    $method = $this->router->getCurrentMethod();

    $this->router->dispatch($uri, $method);
  }
}
