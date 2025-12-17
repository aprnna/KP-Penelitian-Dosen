<?php

require_once '../app/services/GoogleAuthService.php';

class AuthController extends Controller
{
  private $auth;
  private $googleAuth;

  public function __construct()
  {
    $this->auth = new Auth();
    $this->googleAuth = new GoogleAuthService();
  }

  public function login()
  {
    if ($this->auth->check()) {
      $this->redirect('dashboard');
      return;
    }

    $this->render('auth/login', ['title' => 'Login'], 'auth');
  }

  public function doLogin()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = $_POST['username'] ?? '';
      $password = $_POST['password'] ?? '';

      if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username dan password harus diisi';
        $this->redirect('auth/login');
        return;
      }

      if ($this->auth->loginWithPassword($username, $password)) {
        $_SESSION['success'] = 'Login berhasil';
        $this->redirect('dashboard');
      } else {
        $_SESSION['error'] = 'Username atau password salah';
        $this->redirect('auth/login');
      }
    }
  }

  public function register()
  {
    if ($this->auth->check()) {
      $this->redirect('dashboard');
      return;
    }

    $this->render('auth/register', ['title' => 'Register'], 'auth');
  }

  public function doRegister()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'username' => $_POST['username'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
        'full_name' => $_POST['full_name'] ?? ''
      ];

      // Validation
      if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
        $_SESSION['error'] = 'Semua field harus diisi';
        $this->redirect('auth/register');
        return;
      }

      if ($data['password'] !== $data['confirm_password']) {
        $_SESSION['error'] = 'Password tidak cocok';
        $this->redirect('auth/register');
        return;
      }

      if (strlen($data['password']) < 6) {
        $_SESSION['error'] = 'Password minimal 6 karakter';
        $this->redirect('auth/register');
        return;
      }

      if ($this->auth->register($data)) {
        $_SESSION['success'] = 'Registrasi berhasil, silakan login';
        $this->redirect('auth/login');
      } else {
        $_SESSION['error'] = 'Username atau email sudah digunakan';
        $this->redirect('auth/register');
      }
    }
  }

  public function googleLogin()
  {
    try {
      $authUrl = $this->googleAuth->getAuthUrl();
      $_SESSION['google_flow'] = 'login';
      header('Location: ' . $authUrl);
      exit;
    } catch (Exception $e) {
      $_SESSION['error'] = 'Gagal menghubungkan ke Google: ' . $e->getMessage();
      $this->redirect('auth/login');
    }
  }

  public function googleRegister()
  {
    try {
      $authUrl = $this->googleAuth->getAuthUrl();
      $_SESSION['google_flow'] = 'register';
      header('Location: ' . $authUrl);
      exit;
    } catch (Exception $e) {
      $_SESSION['error'] = 'Gagal menghubungkan ke Google: ' . $e->getMessage();
      $this->redirect('auth/login');
    }
  }


  public function googleCallback()
  {
    require_once '../app/services/GoogleAuthService.php';

    $code = $_GET['code'] ?? null;
    $state = $_GET['state'] ?? null;
    $error = $_GET['error'] ?? null;

    // Handle error from Google
    if ($error) {
      $_SESSION['error'] = 'Login Google dibatalkan';
      $this->redirect('auth/login');
      return;
    }

    if (!$code) {
      $_SESSION['error'] = 'Kode authorization tidak diterima';
      $this->redirect('auth/login');
      return;
    }

    try {
      $googleAuth = new GoogleAuthService();

      // Verify state (CSRF protection)
      if (!$googleAuth->verifyState($state)) {
        $_SESSION['error'] = 'Invalid state parameter';
        $this->redirect('auth/login');
        return;
      }

      $token = $googleAuth->authenticate($code);

      if (!$token) {
        $_SESSION['error'] = 'Gagal mendapatkan access token';
        $this->redirect('auth/login');
        return;
      }

      $userInfo = $googleAuth->getUserInfo($token['access_token']);

      if (!$userInfo) {
        $_SESSION['error'] = 'Gagal mendapatkan informasi user';
        $this->redirect('auth/login');
        return;
      }

      $flow = $_SESSION['google_flow'] ?? null;
      unset($_SESSION['google_flow']);

      if ($flow === 'login') {
        $this->loginWithGoogle($userInfo);
      } elseif ($flow === 'register') {
        $this->registerWithGoogle($userInfo);
      } else {
        $_SESSION['error'] = 'Alur Google tidak dikenali';
        $this->redirect('auth/login');
      }
    } catch (Exception $e) {
      error_log('Google Callback Error: ' . $e->getMessage());
      $_SESSION['error'] = 'Terjadi kesalahan saat login dengan Google';
      $this->redirect('auth/login');
    }
  }
  public function loginWithGoogle($googleUser)
  {

    if ($this->auth->loginWithGoogle($googleUser)) {
      $_SESSION['success'] = 'Login dengan Google berhasil';
      $this->redirect('dashboard');
    } else {
      $_SESSION['error'] = 'Gagal login dengan Google';
      $this->redirect('auth/login');
    }
  }
  public function registerWithGoogle($googleUser)
  {
    if ($this->auth->registerWithGoogle($googleUser)) {
      $_SESSION['success'] = 'Registrasi dengan Google berhasil, silakan login';
      $this->redirect('dashboard');
    } else {
      $_SESSION['error'] = 'Gagal registrasi dengan Google';
      $this->redirect('register');
    }
  }

  public function logout()
  {
    $this->auth->logout();
    $_SESSION['success'] = 'Logout berhasil';
    $this->redirect('auth/login');
  }
}
