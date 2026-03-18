<?php

function jsonResponse($payload = [], $status = 200)
{
  http_response_code($status);
  header("Content-Type: application/json");

  echo json_encode(array_merge([
    "success" => $status >= 200 && $status < 300
  ], $payload));

  exit();
}

function errorResponse($message = "Error", $status = 500, $extra = [])
{
  http_response_code($status);
  header("Content-Type: application/json");

  echo json_encode([
    "success" => false,
    "message" => $message,
    "error" => $extra
  ]);
  exit();
}
