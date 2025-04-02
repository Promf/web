<?php

$dbhost = 'localhost';
$dbname = 'mydb';
$dbuser = 'web';
$dbpass = '123123';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

$usernameEscaped = mysqli_real_escape_string($conn, $username);
$passwordEscaped = mysqli_real_escape_string($conn, $password);

$query = "SELECT * FROM user WHERE login = '$usernameEscaped' LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Ошибка запроса: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

if ($user && $user['password'] === $passwordEscaped) {
    setcookie("user", $user['login'], time() + 3600, "/");
    header("Location: main.php");
    exit();

} else {
    $error = urlencode("Неверное имя пользователя или пароль.");
    header("Location: index.html?error=1");
    exit();
}
mysqli_free_result($result);
mysqli_close($conn);
?>
