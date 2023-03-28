<?php
    include "../../../service/config.php";

    header('Content-Type: application/json; charset=utf-8');
    $cook_id = htmlspecialchars($_COOKIE["id"]);
    $mysql = new mysqli($Host, $User, $Password, $Database);

    $result = $mysql->query("SELECT COUNT(*) FROM `messages` WHERE `incoming_msg_id` = '0' AND `outgoing_msg_id` = $cook_id AND `see` = ' false' LIMIT 1");
    $result = $result->fetch_assoc();

    echo $result["COUNT(*)"];  
    
    $mysql->close();  
?>