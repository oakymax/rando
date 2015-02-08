<?php

class User {

    public static function isAuthenticated(){
        if (isset($_SESSION["user_id"])) {
            return true;
        } else {
            return false;
        }
    }

    public static function signOut(){
        unset($_SESSION["user_id"]);
    }

    public static function signIn($name, $password){
        $_SESSION["user_id"] = 1;
        return true;
    }

    public static function signUp($name, $password){
        $_SESSION["user_id"] = 1;
        return true;
    }
}