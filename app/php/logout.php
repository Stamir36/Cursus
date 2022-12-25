<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_COOKIE["id"]);
        if(isset($logout_id)){
            $status = "Не в сети";
            $sql = mysqli_query($conn, "UPDATE accounts_users SET status = '{$status}' WHERE id={$_COOKIE["id"]}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: /");
            }
        }else{
            header("location: ../");
        }
    }else{  
        header("location: ../");
    }
?>