<?php
session_start();

// Load environment variables and config FIRST before any class that depends on them
require_once '../app/core/Env.php';
Env::load();
require_once '../config/config.php';

// Load core classes after constants are defined
require_once '../app/core/Router.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Auth.php';
require_once '../app/middleware/AuthMiddleware.php';
require_once '../app/helpers/csrf_helper.php';
require_once '../app/core/App.php';

$app = new App();
