<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id']; // Мы
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); // Собеседник
        if($_POST['incoming_id'] != "0"){
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
                        $output .= '<div class="chat incoming" style="align-items: end;">
                                        <img style="margin-bottom: 30px; border-radius: 30px; border: 3px solid antiquewhite;" src="/data/users/avatar/'.$avatar.'" alt="">
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
                $output .= '<div class="text" style="display: grid;">
                    <img src="dist/stilus.png" alt="" style="width: 200px; justify-self: center;">
                    <p style="font-family: Unecoin;">История пуста. Как только вы отправите сообщение, они появятся здесь.</p>
                </div>';
            }

            $sql = "UPDATE `messages` SET `see` = 'true' WHERE `incoming_msg_id` = '$outgoing_id' AND `outgoing_msg_id` = '$incoming_id'; ";
            $query = mysqli_query($conn, $sql);

            echo $output;
        }else{
            $output = "";
            $sql = "SELECT * FROM messages LEFT JOIN accounts_users ON accounts_users.id = messages.outgoing_msg_id
                    WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                    OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
            $query = mysqli_query($conn, $sql);
            
            $font = "'Unecoin'";
            $com_help = '<span style="font-family: '.$font.' ;" class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Список актуальных команд</span>';
            $com_translate = '<span style="font-family: '.$font.' ;" class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Перевести текст</span>';
            $com_stablediffusion = '<span style="font-family: '.$font.' ;" class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">Генерация изображения</span>';

            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)){
                    if($row['outgoing_msg_id'] === $outgoing_id){
                        $look = "";
                        $avatar = $incoming_id.".png";

                        $mess = $row['msg'];

                        if (strpos($mess, "/help") !== false) {
                            $mess = $com_help;
                        }
                        if (strpos($mess, "/translate ru to en") !== false) {
                            $mess = str_replace("/translate ru to en", $com_translate, $mess);
                        }
                        if (strpos($mess, "/translate en to ru") !== false) {
                            $mess = str_replace("/translate en to ru", $com_translate, $mess);
                        }
                        if (strpos($mess, "/imageline") !== false) {
                            $mess = str_replace("/imageline", $com_stablediffusion, $mess);
                        }

                        if($row['see'] == "true"){ $look = ' - <span class="inline-flex items-center p-1 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full" style="top: 1px; position: relative; padding: 2px;"><svg aria-hidden="true" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></span>'; }
                            $output .= '<div class="chat outgoing">
                                        <div style="display: grid;">
                                            <div class="details">
                                                <p>'. $mess .'</p>
                                            </div>
                                            <p class="status">'.date("H:i", strtotime($row['time'])).' '.$look.'</p>
                                        </div>
                                    </div>';
                    }else{
                        $output .= '<div class="chat incoming" style="align-items: end;">
                                        <img style="margin-bottom: 30px; border-radius: 30px; border: 3px solid antiquewhite;" src="ai.avatar.png" alt="">
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
                $font = "'Geologica'";
                $font2 = "'Wix Madefor Display'";
                $output .= '
                <aside class="text width-banner p-4 my-8 border border-gray-200 rounded-lg sm:p-6 lg:p-8 dark:bg-gray-800 dark:border-gray-700" style="background: #f0f8ff7a; text-align: left;">
                    <h3 class="mb-3 text-xl font-medium text-gray-900 dark:text-white" style="font-family: '.$font.', sans-serif;">Приветствуем в Cursus Bot AI</h3>
                    <p class="mb-5 text-sm font-medium text-gray-700 dark:text-gray-300 font_Wix">Чат-бот на базе HuggingFace 🤗 написаный и функционирующий на Unesell Studio. Пишите текст, вопросы, а модель искуственного интелекта попробует ответить вам!</p>
                    <a href="https://github.com/Stamir36/CursusAI-ChatBot" target="_blank" type="button" class="px-3 py-2 mb-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 font_Wix">Репозиторий GitHub проекта</a>
                    <a href="https://colab.research.google.com/drive/1BnPDnLK52OPSOVL3TyE7S-_zqI2Nakx-?usp=sharing" target="_blank" type="button" class="px-3 py-2 mb-4 text-xs font-medium text-center text-white focus:outline-none text-white bg-yellow-500 hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg font_Wix">Google Colab проекта</a>
                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300 font_Wix">Продолжая, вы соглашаетесь <a rel="nofollow" href="../../service/rule/" class="text-blue-600 hover:underline dark:text-blue-500 font_Wix">c политикой конфиденциальности</a> Unesell Studio.</div>
                </aside>';
            }

            $sql = "UPDATE `messages` SET `see` = 'true' WHERE `incoming_msg_id` = '$outgoing_id' AND `outgoing_msg_id` = '$incoming_id'; ";
            $query = mysqli_query($conn, $sql);

            echo $output;
        }
    }else{
        header("location: ../login.php");
    }
?>