<?php
    while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['id']}
                OR outgoing_msg_id = {$row['id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        
        (mysqli_num_rows($query2) > 0) ? $result = "Чат: ".$row2['msg'] : $result = $row['about_me'];

        (strlen($result) > 100) ? $msg =  substr($result, 0, 100) . '...' : $msg = $result;

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
    }
?>