<?php

class UserController {

    public function actionIndex(){

    }

    public function actionGet($key){
        if ( Auth::username() != $key ){
            throw new ForbiddenException("authorizaion failed");
        }

        respond([]);
    }

    public function actionPost(){
        $username = get_val($_POST, 'username');
        $password = get_val($_POST, 'password');

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

        respond([
            'id' => $newUserId
        ]);
    }
}