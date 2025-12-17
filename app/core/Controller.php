<?php

class Controller
{

  public function view($view, $data = [])
  {
    extract($data);

    require_once '../app/views/' . $view . '.php';
  }

  /**
   * Render view with layout
   * @param string $view Path to view file
   * @param array $data Data to pass to view
   * @param string $layout Layout to use (main, auth)
   */
  public function render($view, $data = [], $layout = 'main')
  {
    $data['viewContent'] = $view;
    extract($data);

    require_once '../app/views/layouts/' . $layout . '.php';
  }

  public function model($model)
  {
    require_once '../app/models/' . $model . '.php';
    return new $model();
  }

  public function redirect($url)
  {
    header('Location: ' . BASE_URL . $url);
    exit;
  }
}
