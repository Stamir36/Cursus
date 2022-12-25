<?php

  if($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "192.168.0.29"){
    $hostname = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "unesell";
  }
  
  // ДАННЫЕ БАЗЫ ДАННЫХ

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
