<?php
// add_worker.php

// Настройки подключения
$dbhost = 'localhost';
$dbname = 'mydb';
$dbuser = 'web';
$dbpass = '123123';

// Соединяемся
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = [];
$success = false;

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Собираем и валидируем входные данные
    $name     = trim($_POST['name'] ?? '');
    $surname  = trim($_POST['surname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');

    if ($name === '')     $errors[] = 'Введите имя';
    if ($surname === '')  $errors[] = 'Введите фамилию';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Неверный email';
    if ($position === '') $errors[] = 'Введите должность';
    if ($phone === '')    $errors[] = 'Введите телефон';

    // Если нет ошибок — вставляем в БД
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn,
            "INSERT INTO workers (name, surname, email, position, phone) VALUES (?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt, 'sssss', $name, $surname, $email, $position, $phone);
        if (mysqli_stmt_execute($stmt)) {
            $success = true;
        } else {
            $errors[] = 'Ошибка БД: ' . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Добавить сотрудника</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f5f5f5; padding:20px; }
    .form-container { max-width:400px; margin:0 auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    h1 { text-align:center; color:#333; }
    label { display:block; margin-top:15px; font-weight:bold; color:#555; }
    input { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:4px; }
    button { margin-top:20px; width:100%; padding:10px; border:none; border-radius:4px; background:#0066cc; color:#fff; font-size:1em; cursor:pointer; }
    button:hover { background:#005bb5; }
    .errors { background:#ffe5e5; color:#900; padding:10px; border-radius:4px; margin-bottom:15px; }
    .success { background:#e5ffe5; color:#090; padding:10px; border-radius:4px; margin-bottom:15px; }
    a.back { display:block; text-align:center; margin-top:15px; color:#0066cc; text-decoration:none; }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Новый сотрудник</h1>

    <?php if ($success): ?>
      <div class="success">Сотрудник успешно добавлен!</div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
      <div class="errors">
        <ul>
          <?php foreach ($errors as $err): ?>
            <li><?php echo htmlspecialchars($err, ENT_QUOTES); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" action="">
      <label for="name">Имя</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES); ?>">

      <label for="surname">Фамилия</label>
      <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES); ?>">

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">

      <label for="position">Должность</label>
      <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($_POST['position'] ?? '', ENT_QUOTES); ?>">

      <label for="phone">Телефон</label>
      <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES); ?>">

      <button type="submit">Добавить</button>
    </form>

    <a class="back" href="workers.php">← Вернуться к списку</a>
  </div>
</body>
</html>
