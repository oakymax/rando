<?php

class User {

    public static function isAuthenticated(){
        if (isset($_SESSION["username"])) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUsername(){
        return $_SESSION['username'];
    }

    private static function setCredentials($username, $password){
        $_SESSION['username'] = $username;
        $_SESSION['password_md5'] = md5($password);
    }

    private static function clearCredentials(){
        unset($_SESSION["username"]);
        unset($_SESSION["password_md5"]);
    }

    public static function getPasswordMd5(){
        return $_SESSION['password_md5'];
    }

    public static function signOut(){
        self::clearCredentials();
    }

    public static function signIn($username, $password){
        self::setCredentials($username, $password);

        $response = RANDOServer::getInstance()->get("user", $username);

        if (!$response->success()){
            self::clearCredentials();
        }
    }

    public static function signUp($username, $password){
        $response = RANDOServer::getInstance()->post("user", null, [
            "username" => $username,
            "password" => $password
        ]);

        if ($response->success()) {
            self::setCredentials($username, $password);
        }
    }

}