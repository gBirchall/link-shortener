<?php
require 'autoload.php';
$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE `links` (
    `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `url` tinytext NOT NULL,
    `short_url` varchar(5) NOT NULL UNIQUE,
    `created` date NOT NULL
  )";




if ($conn->query($sql) === TRUE) {
    echo "Migration successful" . "\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$conn->close();
