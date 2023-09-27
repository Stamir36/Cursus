<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    
    $sql = "SELECT * FROM group_list ORDER BY identify DESC";
    
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "<a style='width: 100%;display: block;text-align: center;padding: 50px; cursor: default;'><img src='dist/addFriends.png' style='opacity: 0.8; display: initial;'><br>Нет чатов<br><br>Создайте группу или присоеденитесь к ней!</a>";
    }elseif(mysqli_num_rows($query) > 0){
        $countMess = 0;
        while($row = mysqli_fetch_assoc($query)){
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = '{$row['identify']}'
                    OR outgoing_msg_id = '{$row['identify']}') AND (outgoing_msg_id = '{$outgoing_id}' 
                    OR incoming_msg_id = '{$outgoing_id}') ORDER BY msg_id DESC LIMIT 1";
            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="Нет сообщений";
            if($result != "Нет сообщений"){
                
                $users_group = $conn->query("SELECT DISTINCT outgoing_msg_id FROM messages WHERE incoming_msg_id = '{$row['identify']}'");
                $msg = "Участников: ".$users_group->num_rows;
                
                if(isset($row2['outgoing_msg_id'])){
                    ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "Вы: " : $you = "";
                }else{
                    $you = "";
                }
                ($outgoing_id == $row['identify']) ? $hid_me = "hide" : $hid_me = "";
        
                $act = "";
        
                if($row['identify'] == htmlspecialchars($_COOKIE["chatopen"])){
                    $act = "active";
                }

                $counts_sql = "SELECT COUNT(*) AS counts FROM messages WHERE incoming_msg_id = {$outgoing_id} AND outgoing_msg_id = {$row['identify']} AND `see` = ' false'";
                $query_counts = mysqli_query($conn, $counts_sql);
                $row_counts = mysqli_fetch_assoc($query_counts);
                $counts = $row_counts['counts'];

                $not_see = '';
                if($counts != 0){
                    $not_see = '<span class="msg-count inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-gray-700 dark:text-blue-400">'.$counts.'</span>';
                }

                $output .= '<div class="msg '.$act.'" onclick="openGroup(`'.$row['identify'].'`)">
                                <img class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 users-avatar-new" src="/app/cursus/'.$row['icon'].'" alt="icon">
                                <div class="msg-detail">
                                    <div class="msg-username">'.$row['name'].'</div>
                                    <div class="msg-content">
                                        <span class="msg-message">'. $msg .'</span>
                                    </div>
                                </div>
                                '.$not_see.'
                            </div>';
                $countMess = $countMess + 1;

            }
        }
        if($countMess == 0){
            $output .= "<a style='width: 100%;display: block;text-align: center;padding: 50px; cursor: default;'><img src='dist/addFriends.png' style='opacity: 0.8; display: initial;'><br>Нет чатов<br><br>Создайте группу или присоеденитесь к ней!</a>";
        }
    }
    echo $output;
?>