<?php

class auth {
    public function actionSignIn(){

        if (User::isAuthenticated()){
            header("Location: /");
            die();
        }

        if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {
            $name = isset($_REQUEST["username"]) ? $_REQUEST["username"] : "";
            $password = isset($_REQUEST["password"]) ? $_REQUEST["password"] : "";

            if ( User::signIn($name, $password) ) {
                header("Location: /");
                die();
            }
        }

        render_page('signin.html');
    }

    public function actionSignOut(){
        User::signOut();

        header("Location: /");
        die();
    }

    public function actionSignUp(){
        if (User::isAuthenticated()){
            header("Location: /");
            die();
        }

        if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {
            $name = isset($_REQUEST["username"]) ? $_REQUEST["username"] : "";
            $password = isset($_REQUEST["password"]) ? $_REQUEST["password"] : "";

            if ( User::signUp($name, $password) ) {
                header("Location: /");
                die();
            }
        }

        render_page('signup.html');
    }
}