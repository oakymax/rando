<?php

class PhotoController {

    public function actionSend(){

        if (isset($_FILES['photo']) && file_exists($_FILES['photo']['tmp_name'])){
            $response = RANDOServer::getInstance()->post("photo", null, [
                'photo' => '@' . realpath($_FILES['photo']['tmp_name']) .  ";filename={$_FILES['photo']['name']}"
            ]);
        }

        header("Location: /");
        die();
    }
}