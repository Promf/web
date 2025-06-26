<?php
// workers.php

// Проверяем авторизацию (по куке, как в main.php)
if (!isset($_COOKIE['user'])) {
    header("Location: index.html");
    exit();
}

// Параметры подключения
$dbhost = 'localhost';
$dbname = 'mydb';
$dbuser = 'web';
$dbpass = '123123';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

$sql    = "SELECT * FROM workers ORDER BY surname, name";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты сотрудников</title>
    <style>
        /* --- общий стиль, как в main.php --- */
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        .card {
            text-align: left;
            background: #fff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
        .card p {
            margin: 5px 0;
            color: #555;
        }
        .card a {
            color: #007bff;
            text-decoration: none;
        }
        .card a:hover {
            text-decoration: underline;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px 0;
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <!-- Навигация -->
    <header>
        <a href="news.php">Перейти к новостям</a>
        <a href="main.php">Список участников</a>
        <a href="workers.php">Контакты</a>
    </header>

    <div class="container">
        <h2>Контакты сотрудников</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($row['surname'] . ' ' . $row['name'], ENT_QUOTES); ?></h3>
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

        <a href="add_worker.php" class="btn">Добавить сотрудника</a>
        <a href="delete_worker.php" class="btn btn-danger">Удалить сотрудника</a>
    </div>
</body>
</html>

