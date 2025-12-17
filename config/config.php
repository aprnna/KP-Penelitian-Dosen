<?php

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'kp-penelitian-dosen');

// App Configuration
define('APP_NAME', getenv('APP_NAME') ?: 'MVC Application');
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost:8080/');

// Path Configuration
define('ROOT', dirname(__DIR__));

