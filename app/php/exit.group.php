<?php 
    session_start();
    include_once "config.php";

    $id = htmlspecialchars($_COOKIE["id"]);
    $chat = $_POST['chat'];

    $sql = mysqli_query($conn, "DELETE FROM `messages` WHERE (`messages`.`incoming_msg_id` = '{$chat}' AND `messages`.`outgoing_msg_id` = '{$id}');");
?>