<?php

class Router {

    private $controller = null;
    private $actionName = null;

    function __construct($routParam = 'q'){
        $rout = isset($_REQUEST[$routParam]) ? preg_split('/[\/]/', $_REQUEST[$routParam]) : [];
        $controllerName = isset($rout[1]) ? ucfirst(strtolower($rout[1]))."Controller" : null;

        if (class_exists($controllerName)){
            $this->controller = new $controllerName();
        } else {
            $this->controller = new MainController();
        }

        $this->actionName = isset($rout[2]) ? "action".ucfirst(strtolower($rout[2])) : null;
        if (!method_exists($this->controller, $this->actionName)){
            $this->actionName = "actionIndex";
        }
    }

    public function execute(){
        call_user_func([$this->controller, $this->actionName]);
    }

}