<?php

define("__ROOT__", realpath(__DIR__ . "/.."));

session_start();

include(__ROOT__.'/init.php');

(new Router())->execute();
/*
function render_page($templateName = null, $data = []){
    include(__ROOT__.'/views/layout.html');
    die();
}

$q = isset($_REQUEST['q']) ? preg_split('/[\/]/', $_REQUEST['q']) : [];
$controllerName = isset($q[1]) ? ucfirst(strtolower($q[1])) . "Controller" : "";
$actionName = isset($q[2]) ? "action{$q[2]}" : "";

if (file_exists("../controllers/{$controllerName}.php")) {
    require_once(("../controllers/{$controllerName}.php"));

    if ( method_exists($controllerName, $actionName) ) {
        call_user_func([new $controllerName, $actionName]);
    }
}
*/