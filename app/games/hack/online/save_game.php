<?php
    include_once "../../../php/config.php";
    $conn = new mysqli($hostname, $username, $password, $dbname);

    // Получение данных от клиента
    $data = json_decode(file_get_contents("php://input"));

    // Извлечение JSON-данных game и player
    $room = $data->room;
    $gameJSON = $data->game;
    $playerJSON = $data->player;
    $dungeonDeckJSON = $data->dungeonDeck;

    // Подготовленный запрос для выборки записи с указанным identify
    $selectQuery = $conn->prepare("SELECT `identify` FROM `cursus_game` WHERE `identify` = ?");
    $selectQuery->bind_param("s", $room);
    $selectQuery->execute();
    $selectQuery->store_result();

    // Если запись с указанным identify существует
    if ($selectQuery->num_rows > 0) {
        // Выполните операцию UPDATE
        $updateQuery = $conn->prepare("UPDATE `cursus_game` SET `data1` = ?, `data2` = ?, `data3` = ? WHERE `identify` = ?");
        $updateQuery->bind_param("ssss", $gameJSON, $playerJSON, $dungeonDeckJSON, $room);
        $updateQuery->execute();
        $updateQuery->close();
    } else {
        // Выполните операцию INSERT с использованием подготовленного запроса
        $insertQuery = $conn->prepare("INSERT INTO `cursus_game` (`identify`, `data1`, `data2`, `data3`) VALUES (?, ?, ?, ?)");
        $insertQuery->bind_param("ssss", $room, $gameJSON, $playerJSON, $dungeonDeckJSON);
        $insertQuery->execute();
        $insertQuery->close();
    }

    $selectQuery->close();
    $conn->close();

    // Отправка подтверждения клиенту
    echo json_encode(['message' => 'Данные успешно сохранены на сервере.']);
?>
