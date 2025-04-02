<?php

if (!isset($_COOKIE['user'])) {
    header("Location: index.html");
    exit();
}

$dbhost = 'localhost';
$dbname = 'mydb';
$dbuser = 'web';
$dbpass = '123123';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM intern WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<p>Участник удален!</p>";
    } else {
        echo "<p>Ошибка при удалении участника: " . mysqli_error($conn) . "</p>";
    }
}
mysqli_close($conn);
header("Location: main.php");
exit();
?>
