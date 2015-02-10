<?php

class Photo implements JsonSerializable {

    private $id = null;
    private $sender_id = null;
    private $recipient_id = null;
    private $storage_identifier = null;

    public function JsonSerialize(){
        return [
            'id' => $this->id,
            'sender' => User::get($this->sender_id),
            'recipient' => User::get($this->recipient_id),
            'uri' => $this->getUri()
        ];
    }

    private function save(){
        if ( $this->id ){
            SimplePDO::getInstance()->update('photo', [
                'sender' => $this->sender_id,
                'recipient' => $this->recipient_id ?: null,
                'storage_identifier' => $this->storage_identifier
            ], [
                'id' => $this->id
            ]);
        } else {
            $id = SimplePDO::getInstance()->insert('photo', [
                'sender' => $this->sender_id,
                'recipient' => $this->recipient_id ?: null,
                'storage_identifier' => $this->storage_identifier
            ]);
            $this->id = $id;
        }
    }

    public static function get($id){

        $photoData = SimplePDO::getInstance()->get_row('SELECT * FROM photo WHERE id = ?', [$id]);

        if ($photoData) {
            $photo = new self();
            $photo->id = $photoData->id;
            $photo->sender_id = $photoData->sender_id;
            $photo->recipient_id = $photoData->recipient_id;
            $photo->storage_identifier = $photoData->storage_identifier;
            return $photo;
        } else {
            return false;
        }
    }

    public static function select($params = [], $order = []){
        $whereSQL = '';
        foreach( array_keys($params) as $paramKey ) {
            $whereSQL .= ( empty($whereSQL) ? 'WHERE ' : ', ') . $paramKey . ' = ? ';
        }

        $orderSQL = '';
        foreach( $order as $paramKey => $paramValue) {
            $orderSQL .= ( empty($orderSQL) ? 'ORDER BY ' : ', ') . $paramKey . ' ' . $paramValue;
        }

        $rows = SimplePDO::getInstance()->get_results(
            "SELECT id FROM photo {$whereSQL} {$orderSQL}", array_values($params));

        $selection = [];
        foreach ($rows as $row) {
            array_push($selection, Photo::get($row->id));
        }

        return $selection;
    }

    private function __construct(){}

    public function getId(){
        return $this->id;
    }

    public function getSender(){
        if ($sender = User::get($this->sender_id)){
            return $sender;
        } else {
            return null;
        }
    }

    public function getRecipient(){
        if ($recipient = User::get($this->recipient_id)){
            return $recipient;
        } else {
            return null;
        }
    }

    public function setRecipient(User $user){
        $this->recipient_id = $user->getId();
        $this->save();
    }

    public function getUri(){
        return 'http://' . $_SERVER['SERVER_NAME'] . '/photos/' . $this->storage_identifier . '.jpg';
    }

    public static function upload($filename){
        if ($me = User::me()){
            $imagick = new Imagick();

            if ($imagick->readImage($filename)) {

                $storage_identifier = md5((new DateTime())->format('Y-m-d H:i:s u') . rand(0, 1000));

                $imagick->writeImage(__ROOT__."/www/photos/{$storage_identifier}.jpg");

                $image = new self();
                $image->storage_identifier = $storage_identifier;
                $image->sender_id = $me->getId();
                $image->save();

                return $image;
            } else {
                throw new BadRequestException('bad image format');
            }
        } else {
            return false;
        }
    }

}