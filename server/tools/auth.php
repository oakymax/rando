<?php

class Auth {

    private static $userId = null;

    public static function user(){

        if (isset(self::$userId)) {
            return self::$userId;
        }

        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '-';
        $seed = isset($_REQUEST['seed']) ? $_REQUEST['seed'] : '-';
        $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '-';

        $userData = SimplePDO::getInstance()->get_row('SELECT * FROM user WHERE username = ?', [$username]);

        if ( $userData && md5($userData->password_md5 . $seed) == $token ){
            return self::$userId = $userData->id;
        } else {
            return false;
        }
    }

}