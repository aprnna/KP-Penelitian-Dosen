<?php

class AuthMiddleware
{
  public static function handle()
  {
    $auth = new Auth();

    if (!$auth->check()) {
      $_SESSION['error'] = 'Silakan login terlebih dahulu';
      header('Location: ' . BASE_URL . 'auth/login');
      exit;
    }
  }
}
