<?php

class Auth {

    private static $username = null;
    private static $userid = null;

    private static function authenticate(){
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '-';
        $seed = isset($_REQUEST['seed']) ? $_REQUEST['seed'] : '-';
        $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '-';

        $userData = SimplePDO::getInstance()->get_row('SELECT * FROM user WHERE username = ?', [$username]);

        if ( $userData && ( md5($userData->password_md5 . $seed) == $token ) ){
            self::$username = $userData->username;
            self::$userid = $userData->id;
            return true;
        } else {
            return false;
        }
    }

    public static function userid(){
        if (!isset(self::$userid)) {
            self::authenticate();
        }

        return self::$userid;
    }

    public static function username(){
        if (!isset(self::$username)) {
            self::authenticate();
        }

        return self::$username;
    }

}