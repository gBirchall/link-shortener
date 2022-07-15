<?php

require 'vendor/autoload.php';


//load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//autoload classes from controller folder
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once 'Controllers/' . $class . '.php';
});
