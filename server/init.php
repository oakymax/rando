<?php

require_once(__ROOT__.'/tools/http-helper.php');
require_once(__ROOT__.'/tools/router.php');
require_once(__ROOT__.'/tools/auth.php');
require_once(__ROOT__.'/vendor/autoload.php');

$config = require(__ROOT__.'config.php');
if (file_exists(__ROOT__.'/config-local.php')) {
    $config = array_merge($config, include(__ROOT__.'config-local.php'));
}

SimplePDO::getInstance($config['db']);
