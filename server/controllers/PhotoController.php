<?php

class PhotoController {
    function actionIndex(){
        if (!$me = User::me()){
            throw new ForbiddenException('photo listing allowed only for authenticated users');
        }

        $filter = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : 'incoming';

        switch ($filter) {
            case 'incoming':
                $feed = Rando::getIncomingFeed($me);
                break;

            default:
                $feed = Rando::getOutgoingFeed($me);
                break;
        }

        respond($feed);
    }

    function actionPost()
    {
        if (!User::me()) {
            throw new ForbiddenException('photo sending allowed only for authenticated users');
        }

        if (isset($_FILES["photo"]) && file_exists($_FILES["photo"]["tmp_name"])) {
            $photo = Photo::upload($_FILES["photo"]["tmp_name"]);
            respond($photo);
        } else {
            throw new BadRequestException('no image uploaded');
        }
    }
}