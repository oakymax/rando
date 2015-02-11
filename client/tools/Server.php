<?php

class RANDOServerResponse {
    private $success = null;
    private $httpCode = null;
    private $body = null;

    public function success(){
        return $this->success;
    }

    public function httpCode(){
        return $this->httpCode;
    }

    public function body(){
        return $this->body;
    }

    public function getErrorMessage(){
        return isset($this->body()->message) ? $this->body()->message : '';
    }

    public function __construct($curl){
        $response = curl_exec($curl);
        $this->body = json_decode($response);
        $this->httpCode = intval(curl_getinfo($curl, CURLINFO_HTTP_CODE));
        $this->success = $this->httpCode < 400;
    }
}

class RANDOServer {

    private $host;
    private static $instance = null;

    private function __construct($config){
        $this->host = $config['host'];
    }

    private function signParams(&$params){
        if (User::isAuthenticated()){
            $params['seed'] = rand(0, 1000);
            $params['token'] = md5(User::getPasswordMd5() . $params['seed']);
            $params['username'] = User::getUsername();
        }
    }

    public static function getInstance($config = null){
        if (is_null(self::$instance)){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function get($entity, $key = null, $params = []){

        $url = $this->host . "{$entity}/" . ($key ? $key : "");

        $this->signParams($params);

        $first = true;
        foreach ($params as $key => $value){
            $url .= ($first ? '?' : '&'). "{$key}={$value}";
            $first = false;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1
        ));

        $resp = new RANDOServerResponse($curl);

        curl_close($curl);

        return $resp;
    }

    public function post($entity, $key, $params){

        $url = $this->host . "{$entity}/" . ($key ? $key : "");

        $this->signParams($params);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $params
        ));

        $resp = new RANDOServerResponse($curl);
        curl_close($curl);

        return $resp;
    }
}