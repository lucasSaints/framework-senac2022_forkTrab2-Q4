<?php


function dd($input) {
    var_dump($input);
    die();
}

function env($nameOfVariable) {
    return $_ENV[$nameOfVariable];
}

function view($input) {
    echo json_encode($input);
}

function getFrom($param, $array){
    foreach ($array as $value) {
        if($value["name"] == $param) {
            return $value["value"];
        }
    }
    return null;
}