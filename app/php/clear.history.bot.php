<?php 
    session_start();
    include_once "config.php";

    $id = htmlspecialchars($_COOKIE["id"]);

    $sql = mysqli_query($conn, "DELETE FROM `messages` WHERE (`messages`.`incoming_msg_id` = '{$id}' AND `messages`.`outgoing_msg_id` = 0) OR (`messages`.`incoming_msg_id` = 0 AND `messages`.`outgoing_msg_id` = '{$id}');");
?>