<?php
session_start();
require 'autoload.php';

// redirect back to homepage if no url is provided
if (!$_POST) {
    header('Location: /');
    exit;
}
//check token is set and is valid   
if (!isset($_SESSION['_token']) || $_SESSION['_token'] != $_POST['_token']) {
    exit;
}

echo LinkController::generateLink($_POST['url']);
