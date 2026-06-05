<?php

/**
 * CSRF Protection Helper
 *
 * Usage:
 * - In forms: echo csrf_field();
 * - In controllers: csrf_verify() or redirect with error
 */

if (!function_exists('csrf_token')) {
    /**
     * Generate and retrieve CSRF token from session
     */
    function csrf_token(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate hidden input field for CSRF token
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token()) . '">';
    }
}

if (!function_exists('csrf_verify')) {
    /**
     * Verify CSRF token from POST request
     * Returns true if valid, false otherwise
     */
    function csrf_verify(): bool
    {
        $token = $_POST['csrf_token'] ?? '';

        if (empty($token) || !isset($_SESSION['csrf_token'])) {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('csrf_verify_or_fail')) {
    /**
     * Verify CSRF token and redirect with error if invalid
     * @param string $redirectUrl URL to redirect on failure
     */
    function csrf_verify_or_fail(string $redirectUrl = ''): void
    {
        if (!csrf_verify()) {
            $_SESSION['error'] = 'Permintaan tidak valid (CSRF token mismatch). Silakan coba lagi.';
            $url = $redirectUrl ?: (defined('BASE_URL') ? BASE_URL : '/');
            header('Location: ' . $url);
            exit;
        }
    }
}