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

// Удаление
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $worker_id = intval($_POST['worker_id']);
    if ($worker_id > 0) {
        $query = "DELETE FROM workers WHERE id = $worker_id";
        if (mysqli_query($conn, $query)) {
            $message = "Сотрудник успешно удалён.";
            $success = true;
        } else {
            $message = "Ошибка при удалении: " . mysqli_error($conn);
        }
    } else {
        $message = "Неверный ID сотрудника.";
    }
}

// Получаем всех сотрудников
$workers = [];
$result = mysqli_query($conn, "SELECT id, name, surname FROM workers ORDER BY surname, name");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $workers[] = $row;
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Удалить сотрудника</title>
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
      margin-top: 20px;
    }
    select {
      padding: 8px;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 15px;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #dc3545;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn:hover {
      background-color: #c82333;
    }
    .message {
      margin-top: 15px;
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
    <h2>Удалить сотрудника</h2>

    <?php if ($message): ?>
      <div class="message <?php echo $success ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($message, ENT_QUOTES); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($workers)): ?>
      <form method="POST">
        <select name="worker_id" required>
          <option value="">-- Выберите сотрудника --</option>
          <?php foreach ($workers as $worker): ?>
            <option value="<?php echo $worker['id']; ?>">
              <?php echo htmlspecialchars($worker['surname'] . ' ' . $worker['name'], ENT_QUOTES); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">Удалить</button>
      </form>
    <?php else: ?>
      <p>Сотрудники не найдены.</p>
    <?php endif; ?>

    <a href="workers.php" class="back-link">← Назад к контактам</a>
  </div>
</body>
</html>
