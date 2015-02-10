<?php
class MainController {
    function actionIndex(){
        if (User::isAuthenticated()){
            global $config;

            $data = [
                "server" => $config['server']['host'],
                "incomingPhotos" => RANDOServer::getInstance()->get("photo", null, [
                    "filter" => "incoming"
                ])->body(),
                "outgoingPhotos" => RANDOServer::getInstance()->get("photo", null, [
                    "filter" => "outgoing"
                ])->body()
            ];
            render('main', $data);
        } else {
            header("Location: /auth");
            die();
        }
    }
}