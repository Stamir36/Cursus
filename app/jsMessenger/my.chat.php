<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    
    $sql = "SELECT * FROM accounts_users WHERE NOT id = {$outgoing_id} ORDER BY id DESC";
    
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "<a style='padding: 65px;position: absolute;'>Пользователи в системе не найдены.</a>";
    }elseif(mysqli_num_rows($query) > 0){
        $countMess = 0;
        while($row = mysqli_fetch_assoc($query)){
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['id']}
                    OR outgoing_msg_id = {$row['id']}) AND (outgoing_msg_id = {$outgoing_id} 
                    OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="Нет сообщений";
            if($result != "Нет сообщений"){
                (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;

                $mystring = $msg;
                $findme   = 'audio controls src';
                $pos = strpos($mystring, $findme);

                if ($pos !== false) {
                    $msg = "Голосовое сообщение";
                }
                
                if(isset($row2['outgoing_msg_id'])){
                    ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "Вы: " : $you = "";
                }else{
                    $you = "";
                }
                ($row['status'] == "Не в сети") ? $online = "" : $online = "online";
                ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";
        
                $act = "";
        
                if($row['id'] == htmlspecialchars($_COOKIE["chatopen"])){
                    $act = "active";
                }
                
                $output .= "<div class='msg ".$act." ".$online."' onclick='openChat(".$row['id'].")'>
                                <img class='msg-profile' src='/data/users/avatar/". $row['avatar'] ."' alt=''>
                                <div class='msg-detail'>
                                    <div class='msg-username'>".$row['name']."</div>
                                    <div class='msg-content'>
                                        <span class='msg-message'>". $you . $msg ."</span>
                                    </div>
                                </div>
                            </div>";
                $countMess = $countMess + 1;
            }
        }
        if($countMess == 0){
            $output .= "<a style='width: 100%;display: block;text-align: center;padding: 50px; cursor: default;'><img src='dist/addFriends.png' style='opacity: 0.8; padding-left: 10px;'><br>Нет чатов<br><br>Напишите кому-нибудь</a>";
        }
    }
    echo $output;
?>