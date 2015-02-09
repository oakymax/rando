<?php

function get_val($array, $index){
    return isset($array[$index]) ? $array[$index] : null;
}

function render($view, $data){
    $templateName = $view . '.html';
    include(__ROOT__.'/views/layout.html');
    die();
}