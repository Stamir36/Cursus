<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id']; // Мы
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); // Собеседник
        $output = "";
        $sql = "SELECT * FROM messages LEFT JOIN accounts_users ON accounts_users.id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $look = "";
                    $avatar = $incoming_id.".png";

                    if($row['see'] == "true"){ $look = " - Просмотрено"; }
                    $output .= '<div class="chat outgoing">
                                    <div style="display: grid;">
                                        <div class="details">
                                            <p>'. $row['msg'] .'</p>
                                        </div>
                                        <p class="status">'.date("H:i", strtotime($row['time'])).' '.$look.'</p>
                                    </div>
                                </div>';
                }else{
                    $output .= '<div class="chat incoming">
                                    <img style="border-radius: 30px; border: 3px solid antiquewhite;" src="/data/users/avatar/'.$avatar.'" alt="">
                                    <div style="display: grid;">
                                        <div class="details">
                                            <p>'. $row['msg'] .'</p>
                                        </div>
                                        <p style="text-align: left;background: transparent;font-size: 12px;padding: 5px; padding-left: 10px; box-shadow: 0 0 0 0;">'.date("H:i", strtotime($row['time'])).'</p>
                                    </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">
            <img src="dist/stilus.png" alt="" style="width: 200px;">
            <p style="font-family: Unecoin;">История пуста. Как только вы отправите сообщение, они появятся здесь.</p></div>';
        }

        $sql = "UPDATE `messages` SET `see` = 'true' WHERE `incoming_msg_id` = '$outgoing_id' AND `outgoing_msg_id` = '$incoming_id'; ";
        $query = mysqli_query($conn, $sql);

        echo $output;
    }else{
        header("location: ../login.php");
    }

?>