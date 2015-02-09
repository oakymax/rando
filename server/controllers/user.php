<?php

class user {

    public function actionGet(){
        $username = isset($_POST['username']) ? $_POST['username'] : '-';

        $user = SimplePDO::getInstance()->get_row('SELECT id, username FROM user WHERE username = ?', [$username]);

        if ( !$user || $user->id != Auth::user() ){
            throw new Exception('authentication failed');
        }

        die(json_encode($user));
    }

    public function actionPost(){
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if(!$username || !$password) {
            throw new Exception('username and password should not be empty');
        }

        if (!filter_var($username, FILTER_VALIDATE_EMAIL) ){
            throw new Exception('username should be an valid email');
        }

        $passwordRegexp = '/^[a-z0-9_-]{3,18}$/';
        if (!preg_match($passwordRegexp, $password) ){
            throw new Exception("password should match {$passwordRegexp}");
        }

        $user = SimplePDO::getInstance()->get_row('SELECT FROM user WHERE username = ?', [$username]);

        if ($user) {
            throw new Exception("this username is already taken");
        }

        $newUserId = SimplePDO::getInstance()->insert('user', [
            'username' => $username,
            'password_md5' => md5($password)
        ]);
    }
}