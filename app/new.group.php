<?php
    // Подключение к базе данных
    include_once "php/config.php";
    $user_id = htmlspecialchars($_COOKIE["id"]);
    $conn = new mysqli($hostname, $username, $password, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Получение данных из AJAX-запроса
    $groupName = $_POST['GroupName'];
    $groupLink = $_POST['GroupLink'];
    $uploadedFile = $_FILES['uploadfile'];

    // Дополнительная проверка данных и обработка изображения, если необходимо

    // Загрузка изображения на сервер
    $uploadDirectory = 'group/';
    $uploadedFileName = $groupLink . '.' . pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
    $targetPath = $uploadDirectory . $uploadedFileName;

    if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
        // Изображение успешно загружено, теперь вставляем данные в базу данных
        $sql = "INSERT INTO group_list (identify, icon, name) VALUES ('$groupLink', '$targetPath', '$groupName')";

        if ($conn->query($sql) === TRUE) {
            // Отправка успешного ответа обратно клиенту
            echo json_encode(array("success" => true));
        } else {
            // Отправка ответа с ошибкой обратно клиенту
            echo json_encode(array("success" => false, "error" => "Ошибка при добавлении данных в базу данных: " . $conn->error));
        }

        $conn->query("INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `time`, `see`) VALUES (NULL, '$groupLink', '$user_id', ':system:Группа создана', CURRENT_TIMESTAMP, ' false')");
    } else {
        // Отправка ответа с ошибкой обратно клиенту
        echo json_encode(array("success" => false, "error" => "Ошибка при загрузке изображения на сервер."));
    }

    // Закрытие соединения с базой данных
    $conn->close();
?>
