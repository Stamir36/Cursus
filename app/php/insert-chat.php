<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        if(!empty($message)){
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ('{$incoming_id}', '{$outgoing_id}', '{$message}')") or die();
        }

        $currentToken = mysqli_real_escape_string($conn, $_POST['currentToken']);
        if($currentToken != ""){
            $msg = $message;
            $cook_id = htmlspecialchars($_COOKIE["id"]);

            $counts_sql = "SELECT * FROM `accounts_users` WHERE `id` = {$cook_id}";
            $query = mysqli_query($conn, $counts_sql);
            $row_name = mysqli_fetch_assoc($query);
            $name = $row_name['name'];

            $apiKey = 'AIzaSyCoj9xpaHuES994IWK4s33FMQq5G1vzK7Y';
            $url = 'https://fcm.googleapis.com/v1/projects/unesell/messages:send';

            // Данные уведомления
            $notification = array(
                'title' => $name,
                'body' => $msg
            );

            // Получатели
            $recipients = array(
                $currentToken
            );

            // Подготовка данных для отправки
            $data = array(
                'message' => array(
                    'notification' => $notification,
                    'token' => $recipients
                )
            );

            // Установка заголовков
            $headers = array(
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json'
            );

            // Отправка запроса
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($curl);
            curl_close($curl);

            // Обработка ответа
            if ($response === false){
                echo 'Ошибка при отправке уведомления: ' . curl_error($curl);
            } else {
                echo 'Уведомление успешно отправлено: ' . $response;
            }
        }
    }else{
        header("location: ../login.php");
    }
?>