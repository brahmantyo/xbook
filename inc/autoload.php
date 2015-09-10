<?php
require_once('config.php');

function __autoload($class_name){
    $class = explode("_",$class_name);
    $path = implode("/",$class).".php";
    echo get_include_path();
    require_once($path);
}