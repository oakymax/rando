<?php

try {
    require_once('../init.php');

    $q = isset($_REQUEST['q']) ? preg_split('/[\/]/', $_REQUEST['q']) : [];
    $controllerName = isset($q[1]) ? $q[1] : "";
    $instanceId = isset($q[2]) && is_int($q[2]) ? intval($q[2]) : null;

    if (file_exists("../controllers/{$controllerName}.php")) {
        require_once(("../controllers/{$controllerName}.php"));

        $actionName = "action" . ucfirst(strtolower($_SERVER["REQUEST_METHOD"]));
        if (method_exists($controllerName, $actionName))
            call_user_func([new $controllerName, $actionName]);
    }
} catch(Exception $e) {
    header_status( "500" );
    die($e->getMessage());
}

