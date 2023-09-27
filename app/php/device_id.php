<?php
    include_once "config.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentToken = $_POST['currentToken'];
        $cook_id = htmlspecialchars($_COOKIE["id"]);

        // Обновление базы данных
        $sql = "UPDATE `accounts_users` SET `DeviceID_forNotify` = '$currentToken' WHERE `accounts_users`.`id` = $cook_id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'Токен успешно обновлен в базе данных.';
        } else {
            echo 'Произошла ошибка при обновлении токена в базе данных.';
        }
        } else {
        echo 'Недопустимый метод запроса.';
    }
?>
