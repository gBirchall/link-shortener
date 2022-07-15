<?php
session_start();
if (empty($_SESSION['_token'])) {
    $_SESSION['_token'] = bin2hex(random_bytes(32));
}

require 'autoload.php';


//route to correct page
$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);
$url = end($url);


if ($url == '') {
    include 'home.php';
} else {
    RedirectController::redirect($url);
}
