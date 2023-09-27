<?php
    session_start();
    include_once "config.php";

    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    $sql = "SELECT * FROM accounts_users WHERE NOT id = {$outgoing_id} AND (name LIKE '%{$searchTerm}%')";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        $countMess = 0;
        while($row = mysqli_fetch_assoc($query)){
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['id']}
                    OR outgoing_msg_id = {$row['id']}) AND (outgoing_msg_id = {$outgoing_id} 
                    OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="Нет сообщений";
            if($result != "Нет сообщений"){
                (strlen($result) > 28) ? $msg =  substr($result, 0, 1000) . '...' : $msg = $result;

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

                $counts_sql = "SELECT COUNT(*) AS counts FROM messages WHERE incoming_msg_id = {$outgoing_id} AND outgoing_msg_id = {$row['id']} AND `see` = ' false'";
                $query_counts = mysqli_query($conn, $counts_sql);
                $row_counts = mysqli_fetch_assoc($query_counts);
                $counts = $row_counts['counts'];

                $not_see = '';
                if($counts != 0){
                    $not_see = '<span class="msg-count inline-flex items-center justify-center w-6 h-6 mr-2 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-gray-700 dark:text-blue-400">'.$counts.'</span>';
                }

                $output .= '<div class="msg '.$act.' '.$online.'" onclick="openChat('.$row['id'].')">
                                <img class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 users-avatar-new" src="/data/users/avatar/'.$row['avatar'].'" alt="">
                                <div class="msg-detail">
                                    <div class="msg-username">'.$row['name'].'</div>
                                    <div class="msg-content">
                                        <span class="msg-message">'. $you . $msg .'</span>
                                    </div>
                                </div>
                                '.$not_see.'
                            </div>';
                $countMess = $countMess + 1;
            }
        }
    }else{
        $output .= '<a style="padding: 65px;position: absolute;">Пользователи не найдены</a>';
    }
    echo $output;
?>