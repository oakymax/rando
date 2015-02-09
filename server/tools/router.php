<?php

class Router {

    private $controller = null;
    private $actionName = null;
    private $key = null;

    function __construct($routParam = 'q'){
        $rout = isset($_REQUEST[$routParam]) ? preg_split('/[\/]/', $_REQUEST[$routParam]) : [];
        $controllerName = isset($rout[1]) ? ucfirst(strtolower($rout[1]))."Controller" : null;

        if ($controllerName && file_exists(__ROOT__."/controllers/{$controllerName}.php") && class_exists($controllerName)) {
            $this->$controller = new $controllerName();
        } else {
            $this->$controller = new MainController();
        }

        self::$instanceKey = isset($rout[2]) ? $rout[2] : null;

        if (!self::$instanceKey && ($_SERVER["REQUEST_METHOD"] == 'GET')) {
            $this->$actionName = "actionIndex";
        } else {
            $this->$actionName = "action" . ucfirst(strtolower($_SERVER["REQUEST_METHOD"]));
        }
    }

    public function execute(){
        if ($this->key) {
            call_user_func([$this->controller, $this->actionName], $this->key);
        } else {
            call_user_func([$this->controller, $this->actionName]);
        }
    }

}