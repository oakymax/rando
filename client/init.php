<?php

require_once('models/user.php');
require_once('models/server.php');

$config = require('config.php');
if (file_exists('../config-local.php')) {
    $config = array_merge($config, include('config-local.php'));
}

Server::getInstance($config['server']);