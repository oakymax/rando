<?php

function get_val($array, $index){
    return isset($array[$index]) ? $array[$index] : null;
}

function respond($data){
    echo(json_encode($data));
    die();
}