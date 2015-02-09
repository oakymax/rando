<?php

session_start();

include('../init.php');

function render_page($templateName = null, $data = []){
    include('../views/layout.html');
    die();
}

$q = isset($_REQUEST['q']) ? preg_split('/[\/]/', $_REQUEST['q']) : [];
$controllerName = isset($q[1]) ? "$q[1]Controller" : "";
$actionName = isset($q[2]) ? "action{$q[2]}" : "";

if (file_exists("../controllers/{$controllerName}.php")) {
    require_once(("../controllers/{$controllerName}.php"));

    if ( method_exists($controllerName, $actionName) ) {
        call_user_func([new $controllerName, $actionName]);
    }
}

$data = [
    "server" => $config['server']['host']
];
if (User::isAuthenticated()) {
    $data["incomingPhotos"] = RANDOServer::getInstance()->get("photo", null, [
        "filter" => "incoming"
    ])->body();
    $data["outgoingPhotos"] = RANDOServer::getInstance()->get("photo", null, [
        "filter" => "outgoing"
    ])->body();
}

render_page('main.html', $data);