<?php

class AuthController {
    public function actionSignIn(){

        if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {
            $name = isset($_REQUEST["username"]) ? $_REQUEST["username"] : "";
            $password = isset($_REQUEST["password"]) ? $_REQUEST["password"] : "";

            User::signIn($name, $password);
        }

        if (User::isAuthenticated()){
            header("Location: /");
            die();
        }

        render_page('signin.html');
    }

    public function actionSignOut(){
        User::signOut();

        header("Location: /");
        die();
    }

    public function actionSignUp(){
        if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {
            $name = isset($_REQUEST["username"]) ? $_REQUEST["username"] : "";
            $password = isset($_REQUEST["password"]) ? $_REQUEST["password"] : "";
            $password_confirm = isset($_REQUEST["password-confirm"]) ? $_REQUEST["password-confirm"] : "-";

            if ($password_confirm == $password) {
                User::signUp($name, $password);
            }
        }

        if (User::isAuthenticated()){
            header("Location: /");
            die();
        }

        render_page('signup.html');
    }
}