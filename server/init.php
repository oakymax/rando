<?php

require('tools/http-helper.php');
require('vendor/autoload.php');

$config = require('config.php');
if (file_exists('../config-local.php')) {
    include('config-local.php');
}

try {
    $database = new SimplePDO($config["db"]);
} catch( PDOException $e ) {
    header_status( "500" );
    die($e->getMessage());
}