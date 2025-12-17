<?php
session_start();

require_once '../app/core/App.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Router.php';
require_once '../app/core/Database.php';
require_once '../app/core/Env.php';

Env::load();

require_once '../config/config.php';
require_once '../app/core/Auth.php';
require_once '../app/middleware/AuthMiddleware.php';

$app = new App();
