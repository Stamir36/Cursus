<?php
    while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['id']}
                OR outgoing_msg_id = {$row['id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="Нет сообщений";

        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;

        $mystring = $msg;
        $findme   = 'audio controls src';
        $pos = strpos($mystring, $findme);

        if ($pos !== false) {
            $msg = "Голосовое сообщение";
        }
        
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "Ты: " : $you = "";
        }else{
            $you = "";
        }
        ($row['status'] == "Не в сети") ? $offline = "Не в сети" : $offline = "";
        ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";

        $output .= '<a href="chat.php?user_id='. $row['id'] .'">
                    <div class="content">
                    <img src="/data/users/avatar/'. $row['avatar'] .'" alt="">
                    <div class="details">
                        <span>'. $row['name'].'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>