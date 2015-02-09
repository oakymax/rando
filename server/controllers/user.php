<?php

class user {

    public function actionGet($key = null){

        if (is_null($key)){
            throw new BadRequestException("index method for user entity is not implemented");
        }

        if ( Auth::username() != $key ){
            throw new ForbiddenException("authorizaion failed");
        }

        die(json_encode([]));
    }

    public function actionPost(){
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if(!$username || !$password) {
            throw new BadRequestException('username and password should not be empty');
        }

        if (!filter_var($username, FILTER_VALIDATE_EMAIL) ){
            throw new BadRequestException('username should be an valid email');
        }

        $passwordRegexp = '/^[a-z0-9_-]{3,18}$/';
        if (!preg_match($passwordRegexp, $password) ){
            throw new BadRequestException("password should match {$passwordRegexp}");
        }

        $user = SimplePDO::getInstance()->get_row("SELECT * FROM user WHERE username = ?", array($username));

        if ($user) {
            throw new ConflictException("this username is already taken");
        }

        $newUserId = SimplePDO::getInstance()->insert('user', [
            'username' => $username,
            'password_md5' => md5($password)
        ]);

        die(json_encode(['id' => $newUserId]));
    }
}