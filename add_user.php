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

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);

    if (!empty($name) && !empty($surname)) {
        $name = mysqli_real_escape_string($conn, $name);
        $surname = mysqli_real_escape_string($conn, $surname);

        $query = "INSERT INTO intern (name, surname) VALUES ('$name', '$surname')";

        if (mysqli_query($conn, $query)) {
            $message = "Участник успешно добавлен!";
            $success = true;
        } else {
            $message = "Ошибка при добавлении участника: " . mysqli_error($conn);
        }
    } else {
        $message = "Пожалуйста, заполните все поля.";
    }
}

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
      background-color: #f4f4f4;
      text-align: center;
      padding: 20px;
    }
    header {
      margin-bottom: 20px;
    }
    header a {
      margin: 0 10px;
      text-decoration: none;
      font-size: 18px;
      color: #007bff;
      transition: 0.3s;
    }
    header a:hover {
      color: #ff0000;
      font-weight: bold;
    }
    .container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      max-width: 400px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
      text-align: left;
      color: #555;
    }
    input {
      padding: 8px;
      width: 100%;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    .message {
      margin-top: 10px;
      padding: 10px;
      border-radius: 4px;
      background-color: #e7f3fe;
      color: #333;
    }
    .message.success {
      background-color: #d4edda;
      color: #155724;
    }
    .message.error {
      background-color: #f8d7da;
      color: #721c24;
    }
    .back-link {
      display: block;
      margin-top: 20px;
      color: #007bff;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <a href="main.php">Список участников</a>
    <a href="news.php">Новости</a>
    <a href="workers.php">Контакты</a>
  </header>

  <div class="container">
    <h2>Добавить участника</h2>

    <?php if ($message): ?>
      <div class="message <?php echo $success ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($message, ENT_QUOTES); ?>
      </div>
    <?php endif; ?>

    <form action="add_user.php" method="POST">
      <label for="name">Имя:</label>
      <input type="text" id="name" name="name" required>

      <label for="surname">Фамилия:</label>
      <input type="text" id="surname" name="surname" required>

      <button type="submit" class="btn">Добавить</button>
    </form>

    <a href="main.php" class="back-link">← Назад на главную</a>
  </div>
</body>
</html>

