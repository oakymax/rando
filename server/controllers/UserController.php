<?php

class UserController {

    public function actionIndex(){
        if ( $me = User::me() ){
            respond($me);
        } else {
            throw new ForbiddenException("authorizaion failed");
        }
    }

    public function actionGet($key){
        $me = User::me();
        $user = User::get($key);
        if ( $me && $user && $me->getId() == User::get($key)->getId() ){
            respond($me);
        } else {
            throw new ForbiddenException("authorizaion failed");
        }
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

        if (User::usernameOccupied($username)) {
            throw new ConflictException("this username is already taken");
        }

        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->save();

        respond($user);
    }
}