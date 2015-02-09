<?php

class MainController {
    public function actionIndex(){
        respond([
            'message' => 'welcome to RANDO server'
        ]);
    }
}