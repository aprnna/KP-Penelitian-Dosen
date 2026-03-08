<?php

// Database Configuration
// Use 127.0.0.1 instead of localhost to force TCP connection (required for Docker)
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_NAME', getenv('DB_NAME') ?: 'kp-penelitian-dosen');
define('API_URL', getenv('API_URL') ?: 'http://localhost:8000/api/v1/scrape');
define('API_KEY', getenv('API_KEY') ?: '');

// App Configuration
define('APP_NAME', getenv('APP_NAME') ?: 'MVC Application');
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost:8080/');

// Path Configuration
define('ROOT', dirname(__DIR__));

