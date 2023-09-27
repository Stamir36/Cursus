<?
    include_once "config.php";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }
    
    $groupLink = $_POST['GroupLink'];

    $sql = "SELECT COUNT(*) AS count FROM group_list WHERE identify = '$groupLink'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['count'] == 0) {
            echo 'unique';
        } else {
            echo 'not_unique';
        }
    } else {
        echo 'error';
    }

    $conn->close();
?>