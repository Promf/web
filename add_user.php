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

// Обработка формы добавления пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);

    // Проверяем, чтобы поля не были пустыми
    if (!empty($name) && !empty($surname)) {
        // Экранируем данные для предотвращения SQL инъекций
        $name = mysqli_real_escape_string($conn, $name);
        $surname = mysqli_real_escape_string($conn, $surname);

        // Запрос на добавление данных в таблицу "intern"
        $query = "INSERT INTO intern (name, surname) VALUES ('$name', '$surname')";

        if (mysqli_query($conn, $query)) {
            echo "<p>Участник успешно добавлен!</p>";
        } else {
            echo "<p>Ошибка при добавлении участника: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Пожалуйста, заполните все поля.</p>";
    }
}

// Закрываем соединение
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить участника</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        padding: 20px;
      }

      h2 {
        color: #333;
      }

      form {
        margin: 20px 0;
      }

      label {
        display: block;
        margin: 10px 0 5px;
      }

      input {
        padding: 8px;
        width: 100%;
        max-width: 300px;
        margin-bottom: 10px;
      }

      button {
        padding: 10px 15px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
      }

      button:hover {
        background-color: #45a049;
      }

      a {
        display: inline-block;
        margin-top: 20px;
        color: #007BFF;
        text-decoration: none;
      }

      a:hover {
        text-decoration: underline;
      }
      </style>
</head>
<body>
    <h2>Добавить участника</h2>
    <form action="add_user.php" method="POST">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required>

        <label for="surname">Фамилия:</label>
        <input type="text" id="surname" name="surname" required>

        <button type="submit">Добавить</button>
    </form>

    <br>
    <a href="main.php">Назад на главную</a>
</body>
</html>

