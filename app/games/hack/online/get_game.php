<?php
    include_once "../../../php/config.php";
    $conn = new mysqli($hostname, $username, $password, $dbname);
    header('Content-Type: application/json; charset=utf-8');

    if (isset($_GET['group_id'])) {
        $group_id = $_GET['group_id'];
        $selectQuery = $conn->prepare("SELECT `data1`, `data2`, `data3` FROM `cursus_game` WHERE `identify` = ?");
        $selectQuery->bind_param("s", $group_id);
        $selectQuery->execute();
        $selectQuery->store_result();

        // Если запись с указанным идентификатором существует
        if ($selectQuery->num_rows > 0) {
            $selectQuery->bind_result($gameJSON, $playerJSON, $dungeonDeckJSON);
            $selectQuery->fetch();
            $selectQuery->close();

            // Отправка JSON-данных клиенту
            echo json_encode(['game' => $gameJSON, 'player' => $playerJSON, 'dungeonDeck' => $dungeonDeckJSON]);
        } else {
            // Если записи не существует, отправляем пустой ответ
            echo json_encode(['message' => 'Данные не найдены.']);
        }
    } else {
        // Если параметр group_id не был передан, отправляем сообщение об ошибке
        echo json_encode(['error' => 'Отсутствует параметр group_id.']);
    }

    $conn->close();
?>
