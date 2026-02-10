<?php

class Auth
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function check()
  {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
  }

  public function user()
  {
    if (!$this->check()) {
      return null;
    }

    $this->db->query('SELECT id, username, email, full_name, picture FROM users WHERE id = :id');
    $this->db->bind(':id', $_SESSION['user_id']);
    return $this->db->single();
  }

  public function loginWithPassword($username, $password)
  {
    $this->db->query('SELECT * FROM users WHERE (username = :username OR email = :username)  AND is_active = 1');
    $this->db->bind(':username', $username);
    $user = $this->db->single();

    // Plain text password check (for demo purposes only)
    if ($user && $password == $user->password) {
      $this->setUserSession($user);
      $this->updateLastLogin($user->id);
      return true;
    }
    //    // Hashed password check
    //    if ($user && password_verify($password, $user->password)) {

    return false;
  }

  public function loginWithGoogle($googleData): bool
  {
    // Check if user exists with Google ID
    $this->db->query('SELECT * FROM users WHERE google_id = :google_id');
    $this->db->bind(':google_id', $googleData['google_id']);
    $user = $this->db->single();

    if ($user) {
      // User exists, update last login
      $this->setUserSession($user);
      $this->updateLastLogin($user->id);
      $this->updateGoogleData($user->id, $googleData);
      return true;
    } else {
      // Check if email already exists (link accounts)
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $googleData['email']);
      $existingUser = $this->db->single();

      if ($existingUser) {
        // Link Google account to existing user
        $this->linkGoogleAccount($existingUser->id, $googleData);
        $this->setUserSession($existingUser);
        $this->updateLastLogin($existingUser->id);
        return true;
      }
    }

    return false;
  }

  public function registerWithGoogle($googleData): bool
  {
    // Cegah duplicate email
    $this->db->query('SELECT id FROM users WHERE email = :email');
    $this->db->bind(':email', $googleData['email']);

    if ($this->db->single()) {
      return false;
    }

    $userId = $this->createGoogleUser($googleData);
    if ($userId) {
      $this->db->query('SELECT * FROM users WHERE id = :id');
      $this->db->bind(':id', $userId);
      $user = $this->db->single();
      $this->setUserSession($user);
      $this->updateLastLogin($user->id);
      $this->updateGoogleData($user->id, $googleData);
      return true;
    }

    return false;
  }

  private function createGoogleUser($googleData): int
  {
    $this->db->query('INSERT INTO users (username, email, full_name, sso_provider, google_id, picture, is_active) 
                      VALUES (:username, :email, :full_name, "google", :google_id, :picture, 1)');
    $this->db->bind(':username', $googleData['email']);
    $this->db->bind(':email', $googleData['email']);
    $this->db->bind(':full_name', $googleData['name']);
    $this->db->bind(':google_id', $googleData['google_id']);
    $this->db->bind(':picture', $googleData['picture']);

    if ($this->db->execute()) {
      return $this->db->lastInsertId();
    }
    return false;
  }

  private function linkGoogleAccount($userId, $googleData)
  {
    $this->db->query('UPDATE users SET google_id = :google_id, sso_provider = "google", picture = :picture WHERE id = :id');
    $this->db->bind(':id', $userId);
    $this->db->bind(':google_id', $googleData['google_id']);
    $this->db->bind(':picture', $googleData['picture']);
    $this->db->execute();
  }
  private function updateGoogleData($userId, $googleData)
  {
    $this->db->query('UPDATE users SET picture = :picture WHERE id = :id');
    $this->db->bind(':id', $userId);
    $this->db->bind(':picture', $googleData['picture']);
    $this->db->execute();
  }

  public function register($data)
  {
    // Check if username or email exists
    $this->db->query('SELECT id FROM users WHERE username = :username OR email = :email');
    $this->db->bind(':username', $data['username']);
    $this->db->bind(':email', $data['email']);

    if ($this->db->single()) {
      return false;
    }
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

    // Insert user
    $this->db->query('INSERT INTO users (username, email, password, full_name,  is_active) 
                      VALUES (:username, :email, :password, :full_name, 1)');
    $this->db->bind(':username', $data['username']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':password', $hashedPassword);
    $this->db->bind(':full_name', $data['full_name']);

    return $this->db->execute();
  }

  private function setUserSession($user)
  {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['username'] = $user->username;
    $_SESSION['email'] = $user->email;
    $_SESSION['full_name'] = $user->full_name;
    $_SESSION['sso_provider'] = $user->sso_provider ?? null;
    $_SESSION['picture'] = $user->picture ?? null;
  }

  private function updateLastLogin($userId)
  {
    $this->db->query('UPDATE users SET last_login = NOW() WHERE id = :id');
    $this->db->bind(':id', $userId);
    $this->db->execute();
  }

  public function logout()
  {
    session_unset();
    session_destroy();
    return true;
  }

  public function id()
  {
    return $_SESSION['user_id'] ?? null;
  }
}
