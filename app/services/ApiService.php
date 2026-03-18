<?php

require_once __DIR__ . '/../core/ApiException.php';

class ApiService
{
  private $apiBaseUrl;
  private $apiKey;

  public function __construct()
  {
    $this->apiBaseUrl = API_URL;
    $this->apiKey = API_KEY;
  }

  public function request($endpoint, $method = "GET", $data = null)
  {
    $url = $this->apiBaseUrl . $endpoint;
    $ch = curl_init($url);

    $headers = [
      "Content-Type: application/json",
      "X-API-Key: " . $this->apiKey,
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    if ($method === "POST") {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data ? json_encode($data) : "{}");
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    curl_close($ch);

    if ($error) {
      throw new ApiException($error, 500);
    }

    if ($httpCode < 200 || $httpCode >= 300) {
      throw new ApiException("HTTP Error: " . $httpCode, $httpCode);
    }

    return json_decode($response, true);
  }
}
