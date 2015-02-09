<?php

class server {

    private $host;
    private static $instance = null;

    private function __construct($config){
        $this->host = $config['host'];
    }

    public static function getInstance($config = null){
        if (is_null(self::$instance)){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function get($params){

        $url = $this->host . 'user/';
        if (User::isAuthenticated()){
            $params['seed'] = rand(0, 1000);
            $params['token'] = md5(User::getPasswordMd5() . $params['seed']);
        }

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

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

    public function post($params){

        $url = $this->host;
        if (User::isAuthenticated()){
            $seed = rand(0, 1000);
            $token = md5(User::getPasswordMd5() . $params['seed']);

            $url += "?username=" . User::getUsername() . "&token={$token}&seed={$seed}";
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $params
        ));

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }
}