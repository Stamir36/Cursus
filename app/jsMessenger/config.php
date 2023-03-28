<?php

  if($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "192.168.0.29"){
    $hostname = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "unesell";
  }else{
    $hostname = 'localhost';
    $username = 'u409496471_unesell';
    $password = 'Stas1214';
    $dbname = 'u409496471_unesell';
  }


  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
