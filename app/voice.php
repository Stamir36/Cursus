<?php
    session_start();

    $uploadDir = './voice/';
    $typeFile = explode('/', $_FILES['voice']['type']);
    $uploadFile = $uploadDir . basename(md5($_FILES['voice']['tmp_name'].time()).'.'.$typeFile[1]);
    if (move_uploaded_file($_FILES['voice']['tmp_name'], $uploadFile)) {
        include_once "php/config.php";

        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, htmlspecialchars($_COOKIE["chatopen"]));
        $message = mysqli_real_escape_string($conn, "<audio controls src='$uploadFile'></audio>");

        if(!empty($message)){
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }
        $response = ['result'=>'OK', 'data'=>$uploadFile];
    } else {
        $response = ['result'=>'ERROR', 'data'=>''];
    }
    echo json_encode($response);
?>