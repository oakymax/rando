<?php

require_once(__ROOT__.'/vendor/autoload.php');

require_once(__ROOT__.'/tools/http-helper.php');
require_once(__ROOT__.'/tools/router.php');
require_once(__ROOT__.'/tools/common.php');

require_once(__ROOT__.'/models/User.php');
require_once(__ROOT__.'/models/Photo.php');
require_once(__ROOT__.'/models/Rando.php');

require_once(__ROOT__.'/controllers/MainController.php');
require_once(__ROOT__.'/controllers/PhotoController.php');
require_once(__ROOT__.'/controllers/UserController.php');

$config = require(__ROOT__.'/config.php');
if (file_exists(__ROOT__.'/config-local.php')) {
    $config = array_merge($config, include(__ROOT__.'/config-local.php'));
}

SimplePDO::getInstance($config['db']);
