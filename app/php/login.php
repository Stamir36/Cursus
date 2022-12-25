<?php 
    session_start();
    include_once "config.php";

    $id = htmlspecialchars($_COOKIE["id"]);

    $sql = mysqli_query($conn, "SELECT * FROM accounts_users WHERE id = '{$id}'");
    
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
        
        $status = "Онлайн";
        $sql2 = mysqli_query($conn, "UPDATE accounts_users SET status = '{$status}' WHERE id = {$row['id']}");
        $_SESSION['unique_id'] = $row['id'];

        echo "users.php";
        header('Location: users.php');
    }else{
        header('Location: /');
    }
?>