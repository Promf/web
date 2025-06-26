<?php
// workers.php

// Параметры подключения
$dbhost = 'localhost';
$dbname = 'mydb';
$dbuser = 'web';
$dbpass = '123123';

// Подключаемся
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Запрос
$sql = "SELECT id, name, surname, email, position, phone FROM workers ORDER BY surname, name";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Сотрудники</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:20px; }
    h1 { text-align:center; color:#333; margin-bottom:30px; }
    .grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(260px,1fr)); gap:20px; }
    .card { background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); padding:20px; transition:transform .2s, box-shadow .2s; }
    .card:hover { transform:translateY(-4px); box-shadow:0 4px 12px rgba(0,0,0,0.15); }
    .card h2 { margin:0 0 10px; font-size:1.2em; color:#222; }
    .card p { margin:6px 0; font-size:0.95em; color:#555; }
    .card a { color:#0066cc; text-decoration:none; }
    .card a:hover { text-decoration:underline; }
    .add-link { display:block; text-align:center; margin-bottom:20px; color:#0066cc; text-decoration:none; font-weight:bold; }
  </style>
</head>
<body>
  <h1>Наши сотрудники</h1>
  <a class="add-link" href="add_worker.php">+ Добавить сотрудника</a>

  <div class="grid">
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
          <h2><?php echo htmlspecialchars($row['surname'] . ' ' . $row['name'], ENT_QUOTES); ?></h2>
          <p><strong>Должность:</strong> <?php echo htmlspecialchars($row['position'], ENT_QUOTES); ?></p>
          <p><strong>Email:</strong>
            <a href="mailto:<?php echo htmlspecialchars($row['email'], ENT_QUOTES); ?>">
              <?php echo htmlspecialchars($row['email'], ENT_QUOTES); ?>
            </a>
          </p>
          <p><strong>Телефон:</strong>
            <a href="tel:<?php echo htmlspecialchars($row['phone'], ENT_QUOTES); ?>">
              <?php echo htmlspecialchars($row['phone'], ENT_QUOTES); ?>
            </a>
          </p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Сотрудники не найдены.</p>
    <?php endif; ?>
    <?php mysqli_close($conn); ?>
  </div>
</body>
</html>

