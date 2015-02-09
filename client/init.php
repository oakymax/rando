<?php

require_once(__ROOT__.'/models/User.php');

require_once(__ROOT__.'/tools/Server.php');
require_once(__ROOT__.'/tools/Router.php');
require_once(__ROOT__.'/tools/common.php');

require_once(__ROOT__.'/controllers/MainController.php');
require_once(__ROOT__.'/controllers/AuthController.php');
require_once(__ROOT__.'/controllers/PhotoController.php');

global $config;
$config = include(__ROOT__.'/config.php');
if (file_exists(__ROOT__.'/config-local.php')) {
    $config = array_merge($config, include(__ROOT__.'/config-local.php'));
}

RANDOServer::getInstance($config['server']);