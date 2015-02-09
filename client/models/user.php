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

    public static function getPasswordMd5(){
        return $_SESSION['password_md5'];
    }

    public static function signOut(){
        unset($_SESSION["username"]);
        unset($_SESSION["password_md5"]);
    }

    public static function signIn($username, $password){

        $response = Server::getInstance()->get([
            'username' => $username,
            'password' => $password
        ]);

        $_SESSION["username"] = $username;
        $_SESSION["password_md5"] = md5($password);
        return true;
    }

    public static function signUp($username, $password){
        $_SESSION["username"] = $username;
        self::signIn($username, $password);
        return true;
    }
}