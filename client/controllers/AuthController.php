<?php

class AuthController {
    public function actionIndex(){
        $username = get_val($_REQUEST, "username");
        $password = get_val($_REQUEST, "password");
        $message = null;

        if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {
            $response = User::signIn($username, $password);
            if (!$response->success()){
                $message = 'user not found';
            }
        }

        if (User::isAuthenticated()){
            header("Location: /");
            die();
        }

        render('signin', [
            'username' => $username ?: '',
            'message' => $message ?: ''
        ]);
    }

    public function actionSignOut(){
        User::signOut();

        header("Location: /");
        die();
    }

    public function actionSignUp(){
        $username = get_val($_REQUEST, "username");
        $password = get_val($_REQUEST, "password");
        $password_confirm = get_val($_REQUEST, "password_confirm");
        $message = null;

        if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {

            if (!filter_var($username, FILTER_VALIDATE_EMAIL)){
                $message = 'username should be a valid email';
            } elseif (empty($password)){
                $message = 'password cannot be empty';
            } elseif ($password_confirm != $password) {
                $message = 'wrong password confirmation';
            } else {
                $response = User::signUp($username, $password);

                if (!$response->success()) {
                    $message = 'sign up failed: ' . $response->getErrorMessage();
                }
            }
        }

        if (User::isAuthenticated()){
            header("Location: /");
            die();
        }

        render('signup', [
            'username' => $username,
            'message' => $message
        ]);
    }
}