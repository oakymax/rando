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
}