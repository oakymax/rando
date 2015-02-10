<?php

class User implements JsonSerializable {

    private static $authenticatedUser = null;

    private $id = null;
    private $password_md5 = null;

    public $username = null;

    public static function get($key){

        $userData = SimplePDO::getInstance()->get_row('SELECT * FROM user WHERE username = ? or id = ?', [$key, $key]);

        if ($userData) {
            $user = new self();
            $user->id = $userData->id;
            $user->username = $userData->username;
            $user->password_md5 = $userData->password_md5;
            return $user;
        } else {
            return false;
        }
    }

    public function JsonSerialize(){
        return [
            'id' => $this->getId(),
            'username' => $this->username
        ];
    }

    public function getId(){
        return $this->id;
    }

    public function setPassword($password){
        $this->password_md5 = md5($password);
    }

    public static function usernameOccupied($username){
        if (self::get($username)) {
            return true;
        } else {
            return false;
        }
    }

    public function save(){
        if ( $this->id ){
            SimplePDO::getInstance()->update('user', [
                'username' => $this->username,
                'password_md5' => $this->password_md5
            ], [
                'id' => $this->id
            ]);
        } else {
            $id = SimplePDO::getInstance()->insert('user', [
                'username' => $this->username,
                'password_md5' => $this->password_md5
            ]);
            $this->id = $id;
        }
    }

    public function delete(){
        SimplePDO::getInstance()->delete('user', ['id' => $this->id]);
        $this->id = null;
    }

    public static function me(){

        if (self::$authenticatedUser) {
            return self::$authenticatedUser;
        } else {
            $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '-';
            $seed = isset($_REQUEST['seed']) ? $_REQUEST['seed'] : '-';
            $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '-';

            $user = self::get($username);
            if ( $user && ( md5($user->password_md5 . $seed) == $token ) ){
                return self::$authenticatedUser = $user;
            } else {
                return false;
            }
        }
    }

}