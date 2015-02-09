<?php

class PhotoController {
    function actionIndex(){
        if (!Auth::username()){
            throw new ForbiddenException('photo listing allowed only for authenticated users');
        }

        $filter = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : 'all';

        switch ($filter) {
            case 'incoming':
                $rows = SimplePDO::getInstance()->get_results("
                    SELECT storage_identifier FROM photo
                    WHERE recipient = ?
                    ORDER BY sent_time DESC", [Auth::userid()]);
                break;

            case 'outgoing':
                $rows = SimplePDO::getInstance()->get_results("
                    SELECT storage_identifier FROM photo
                    WHERE sender = ?
                    ORDER BY sent_time DESC", [Auth::userid()]);
                break;

            case 'all':
                $rows = SimplePDO::getInstance()->get_results("
                    SELECT storage_identifier FROM photo
                    WHERE sender = ? or recipient = ?
                    ORDER BY sent_time DESC", [Auth::userid(), Auth::userid()]);
                break;
        }

        respond($rows);
    }

    function actionPost()
    {
        if (!Auth::username()) {
            throw new ForbiddenException('photo sending allowed only for authenticated users');
        }

        $imagick = new Imagick();

        if (isset($_FILES["photo"]) && file_exists($_FILES["photo"]["tmp_name"]) && $imagick->readImage($_FILES["photo"]["tmp_name"])) {

            $storage_identifier = md5((new DateTime())->format('Y-m-d H:i:s u') . rand(0, 1000));

            $imagick->writeImage("../web/photos/{$storage_identifier}.jpg");
            SimplePDO::getInstance()->insert('photo', [
                'storage_identifier' => $storage_identifier,
                'sender' => Auth::userid()
            ]);

            respond([
                "storage_identifier" => $storage_identifier
            ]);

        } else {
            throw new BadRequestException('bad image format or no image uploaded');
        }
    }
}