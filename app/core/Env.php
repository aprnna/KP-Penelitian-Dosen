<?php

/**
 * Simple .env file loader
 * Loads environment variables from .env file into getenv(), $_ENV, and $_SERVER
 */
class Env
{
  private static $loaded = false;

  /**
   * Load .env file
   */
  public static function load($path = null)
  {
    if (self::$loaded) {
      return;
    }

    if ($path === null) {
      $path = dirname(__DIR__, 2) . '/.env';
    }

    if (!file_exists($path)) {
      return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
      // Skip comments
      if (strpos(trim($line), '#') === 0) {
        continue;
      }

      // Parse key=value
      if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Remove quotes if present
        if (preg_match('/^(["\'])(.*)\\1$/', $value, $matches)) {
          $value = $matches[2];
        }

        // Set environment variable
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
      }
    }

    self::$loaded = true;
  }

  /**
   * Get environment variable with fallback
   */
  public static function get($key, $default = null)
  {
    $value = getenv($key);
    return $value !== false ? $value : $default;
  }
}
