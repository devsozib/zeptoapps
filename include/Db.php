<?php
    // Configuration
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'zepto';
    $uploadDir = 'uploads/';
    $allowedTypes = ['ttf'];

    // Connect to the database
    $connection = new mysqli($host, $user, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
?>
