<?php

class Rando {
    public static function getIncomingFeed(User $user){

        return Photo::select([
            'recipient' => $user->getId()
        ], [
            'sent_time' => 'DESC'
        ]);

    }

    public static function getOutgoingFeed(User $user){

        return Photo::select([
            'sender' => $user->getId()
        ], [
            'sent_time' => 'DESC'
        ]);

    }

    public static function sendPhotoToRandomUser(Photo &$photo){
        if (!$photo->getRecipient()) {
            $row = SimplePDO::getInstance()->get_row(
                "SELECT id FROM user WHERE NOT id = ? ORDER BY RAND() LIMIT 0,1",
                [$photo->getSender()->getId()]);

            if ($row) {
                $photo->setRecipient(User::get($row->id));
            }
            return true;
        } else {
            return false;
        }
    }
}