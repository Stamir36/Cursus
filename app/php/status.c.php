<?php
    include_once "config.php";

    header('Content-Type: application/json; charset=utf-8');

    $mysql = new mysqli($hostname, $username, $password, $dbname);

    $id = htmlspecialchars($_COOKIE["chatopen"]);

    $result = $mysql->query("SELECT status FROM `accounts_users` WHERE `id` = '$id'");
    $result = $result->fetch_assoc();

    echo json_encode($result);  
    
    $mysql->close();  
?>