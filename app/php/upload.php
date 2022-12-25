<?php
  $file_name =  $_FILES['file']['name'];
  $tmp_name = $_FILES['file']['tmp_name'];
  $file_up_name = time().$file_name;
  move_uploaded_file($tmp_name, "../files/".$file_up_name);

  session_start();
  if(isset($_SESSION['unique_id'])){
      include_once "config.php";

      $outgoing_id = $_SESSION['unique_id'];
      $incoming_id = mysqli_real_escape_string($conn, htmlspecialchars($_COOKIE["chatopen"]));
      $message = mysqli_real_escape_string($conn, "<img style='max-height: 400px; border-radius: 5px; max-width: 500px; width: 100%; height: 100%;' src='/app/cursus/files/".$file_up_name."' alt='image file'>");

      if(!empty($message)){
          $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                      VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
      }
  }else{
      header("location: ../login.php");
  }
?>
