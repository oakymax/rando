<?php

session_start();

include('../includes.php');

function render_page($templateName = null){
    include('../views/layout.html');
    die();
}

$q = isset($_REQUEST['q']) ? preg_split('/[\/]/', $_REQUEST['q']) : [];
$controllerName = isset($q[1]) ? $q[1] : "";
$actionName = isset($q[2]) ? "action{$q[2]}" : "";

if (file_exists("../controllers/{$controllerName}.php")) {
    require_once(("../controllers/{$controllerName}.php"));

    if ( method_exists($controllerName, $actionName) )
        call_user_func([new $controllerName, $actionName]);
}

render_page();