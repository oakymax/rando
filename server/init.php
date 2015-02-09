<?php

require_once('tools/http-helper.php');
require_once('tools/auth.php');
require_once('vendor/autoload.php');

$config = require('config.php');
if (file_exists('../config-local.php')) {
    $config = array_merge($config, include('config-local.php'));
}

SimplePDO::getInstance($config['db']);
