<?php
    include_once "../php/config.php";

    $chat = $_GET['id'];
    $inapp = $_GET['inapp'];
    $user_id = htmlspecialchars($_COOKIE["id"]);

    $conn = new mysqli($hostname, $username, $password, $dbname);
    $sql = mysqli_query($conn, "SELECT * FROM accounts_users WHERE id = $user_id");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
    }

    $sys = ":system:".$row['name']." теперь в нашей тусовке!";
    
    $conn->query("INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `time`, `see`) VALUES (NULL, '$chat', '$user_id', '$sys', CURRENT_TIMESTAMP, ' false')");
    
    if(empty($inapp)){
        header("location: ../?group=".$chat);
    }else{
        echo("<script>parent.openGroup('".$chat."');</script> ");
    }
?>