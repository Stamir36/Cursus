<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id']; // Мы
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); // Собеседник
        
        $output = "";
            $sql = "SELECT * FROM messages LEFT JOIN accounts_users ON accounts_users.id = messages.outgoing_msg_id
                    WHERE incoming_msg_id = '{$incoming_id}' ORDER BY msg_id";

            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) > 0){
                $currentDate = null;
                setlocale(LC_TIME, 'ru_RU.utf8');
                $months = array( 1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря' );
                
                while($row = mysqli_fetch_assoc($query)){

                    $date = date("d.m.Y", strtotime($row['time']));
    
                    if ($date != $currentDate) {
                        $datetime = new DateTime($row['time']);
                        $day = $datetime->format('j');
                        $month = $datetime->format('n');
                        $year = $datetime->format('Y');
                        
                        $now = $day . ' ' . $months[$month] . ' ' . $year;
                        
                        $time = '<div class="text-center">
                                    <span class="f-Manrope bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">'.$now.'</span>
                                </div>';
                                
                        $output .= $time;
                        $currentDate = $date;
                    }

                    if (strstr($row['msg'], ":system:")) {
                        $SystemMSG = str_replace(":system:", "", $row['msg']);
                        $msg = '<div class="text-center">
                                    <span class="f-Manrope bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">'.$SystemMSG.'</span>
                                </div>';
                                
                        $output .= $msg;
                        continue;
                    }

                    if($row['outgoing_msg_id'] === $outgoing_id){
                        $look = "";
                        $avatar = $row['outgoing_msg_id'].".png";

                        if($row['see'] == "true"){ $look = ' - <span class="inline-flex items-center p-1 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full" style="top: 1px; position: relative; padding: 2px;"><svg aria-hidden="true" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></span>'; }
                        $output .= '<div class="chat outgoing">
                                        <div style="display: grid;">
                                            <div class="details">
                                                <p>'. $row['msg'] .'</p>
                                            </div>
                                            <p class="status">'.date("H:i", strtotime($row['time'])).' '.$look.'</p>
                                        </div>
                                    </div>';
                    }else{
                        $avatar = $row['outgoing_msg_id'].".png";

                        $sql = mysqli_query($conn, "SELECT * FROM accounts_users WHERE id = {$row['outgoing_msg_id']}");
                        $user = mysqli_fetch_assoc($sql);

                        $output .= '<div class="chat incoming" style="align-items: end;">
                                        <img data-popover-target="popover-user-profile-'.$row['outgoing_msg_id'].'" data-popover-placement="right" style="margin-bottom: 30px; border-radius: 30px; border: 3px solid antiquewhite; object-fit: cover;" src="/data/users/avatar/'.$avatar.'" alt="">
                                        <div style="display: grid;">
                                            <div class="details">
                                                <p>'. $row['msg'] .'</p>
                                            </div>
                                            <p style="text-align: left;background: transparent;font-size: 12px;padding: 5px; padding-left: 10px; box-shadow: 0 0 0 0;">'.date("H:i", strtotime($row['time'])).'</p>
                                        </div>
                                    </div>                                 
                                    
                                    <div data-popover id="popover-user-profile-'.$row['outgoing_msg_id'].'" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                        <div class="p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <div style="display: inline-flex;">
                                                    <img class="w-10 h-10 rounded-full" src="/data/users/avatar/'.$avatar.'" alt="Jese Leos">
                                                    <div style="margin-left: 10px;">
                                                        <p class="text-base font-semibold leading-none text-gray-900 dark:text-white font_Wix">
                                                            <a>'.$user['name'].'</a>
                                                        </p>
                                                        <p class="mb-3 text-sm font-normal">
                                                            <a class="hover:underline font_Wix">@'.$user['id'].'</a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="font_Wix text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Написать</button>
                                                </div>
                                            </div>
                                            <p class="mb-4 text-sm font_Wix">'.$user['about_me'].'</p>
                                        </div>
                                        <div data-popper-arrow></div>
                                    </div>
                                    ';
                    }
                }
            }else{
                $output .= '<div class="text" style="display: grid;">
                    <img src="dist/stilus.png" alt="" style="width: 200px; justify-self: center;">
                    <p style="font-family: Unecoin;">История пуста. Как только вы отправите сообщение, они появятся здесь.</p>
                </div>';
            }

            echo $output;
    }else{
        header("location: ../login.php");
    }
?>