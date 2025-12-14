<?php

class GoogleAuthService
{
  private $config;

  public function __construct()
  {
    $this->config = require __DIR__ . '/../../config/google.php';
  }

  /**
   * Get authorization URL untuk redirect ke Google
   */
  public function getAuthUrl()
  {
    $state = bin2hex(random_bytes(16));
    $_SESSION['google_auth_state'] = $state;

    $params = [
      'client_id' => $this->config['client_id'],
      'redirect_uri' => $this->config['redirect_uri'],
      'response_type' => 'code',
      'scope' => $this->config['scopes'],
      'state' => $state,
    ];

    return $this->config['auth_url'] . '?' . http_build_query($params);
  }

  /**
   * Verify state untuk mencegah CSRF attack
   */
  public function verifyState($state)
  {
    if (empty($state) || empty($_SESSION['google_auth_state'])) {
      return false;
    }

    $isValid = $state === $_SESSION['google_auth_state'];
    unset($_SESSION['google_auth_state']);

    return $isValid;
  }

  /**
   * Exchange authorization code untuk access token
   */
  public function authenticate($code)
  {
    $params = [
      'code' => $code,
      'client_id' => $this->config['client_id'],
      'client_secret' => $this->config['client_secret'],
      'redirect_uri' => $this->config['redirect_uri'],
      'grant_type' => 'authorization_code'
    ];

    $response = $this->makeRequest($this->config['token_url'], $params, 'POST');

    if (isset($response['access_token'])) {
      return $response;
    }

    // Log error
    if (isset($response['error'])) {
      error_log('Google Auth Error: ' . json_encode($response));
    }

    return false;
  }

  /**
   * Get user info from Google
   */
  public function getUserInfo($accessToken)
  {

    $headers = ['Authorization: Bearer ' . $accessToken];

    $url = $this->config['user_info_url'];

    $response = $this->makeRequest($url, [], 'GET', $headers);

    if (isset($response['id'])) {
      return [
        'google_id' => $response['id'],
        'email' => $response['email'] ?? '',
        'name' => $response['name'] ?? '',
        'given_name' => $response['given_name'] ?? '',
        'family_name' => $response['family_name'] ?? '',
        'picture' => $response['picture'] ?? '',
        'verified_email' => $response['verified_email'] ?? false,
      ];
    }

    return false;
  }

  /**
   * Make HTTP request menggunakan cURL
   */
  private function makeRequest($url, $data = [], $method = 'GET', $headers = [])
  {
    $ch = curl_init();

    if ($method === 'POST') {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    } elseif ($method === 'GET' && !empty($data)) {
      $url .= '?' . http_build_query($data);
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    $defaultHeaders = [
      'Accept: application/json',
      'Content-Type: application/x-www-form-urlencoded'
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($defaultHeaders, $headers));


    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    curl_close($ch);

    if ($error) {
      error_log('cURL Error: ' . $error);
      return false;
    }

    if ($httpCode >= 400) {
      error_log('HTTP Error ' . $httpCode . ': ' . $response);
      return json_decode($response, true) ?: false;
    }

    return json_decode($response, true);
  }

  /**
   * Revoke token (untuk logout dari Google)
   */
  public function revokeToken($accessToken)
  {
    $url = 'https://oauth2.googleapis.com/revoke';
    $params = ['token' => $accessToken];

    $response = $this->makeRequest($url, $params, 'POST');

    return $response !== false;
  }
}
