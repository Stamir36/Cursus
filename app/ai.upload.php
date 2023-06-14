<?php
    $target_dir = "files/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Проверка, является ли файл изображением
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            echo "Файл является изображением - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Файл не является изображением.";
            $uploadOk = 0;
        }
    }

    // Проверка, существует ли уже файл с таким именем
    if (file_exists($target_file)) {
        echo "Файл с таким именем уже существует.";
        $uploadOk = 0;
    }

    // Проверка размера файла
    if ($_FILES["file"]["size"] > 5000000) {
        echo "Размер файла слишком большой.";
        $uploadOk = 0;
    }

    // Позволяет загрузку только определенных типов файлов
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Разрешены только файлы JPG, JPEG, PNG и GIF.";
        $uploadOk = 0;
    }

    // Проверка наличия ошибок загрузки
    if ($uploadOk == 0) {
        echo "Возникла ошибка при загрузке файла.";
    // Если все проверки пройдены успешно, перемещаем файл в нужную папку
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "Файл ". basename( $_FILES["file"]["name"]). " успешно загружен.";
        } else {
            echo "Возникла ошибка при загрузке файла.";
        }
    }
?>
