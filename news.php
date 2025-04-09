<?php
// Подключение к базе данных
$mysqli = new mysqli("localhost", "web", "123123", "mydb");
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

// Обработка формы добавления новости
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $news_text = $_POST['news_text'];
    $image = $_POST['image'];

    $sql = "INSERT INTO news (name, news_text, image) VALUES ('$name', '$news_text', '$image')";
    $mysqli->query($sql);
}

// Обработка поиска (уязвимая часть)
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM news WHERE name LIKE '%$search%' ORDER BY id DESC"; // <-- SQL-инъекция возможна здесь
$result = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f5f5f5;
            color: #333;
            padding: 40px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }
        form {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #1d72b8;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #145a8d;
        }
        .news-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .news-item img {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 8px;
        }
        .search-form {
            margin-bottom: 30px;
        }
        .search-form input[type="text"] {
            padding: 10px;
            width: 70%;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .search-form input[type="submit"] {
            background-color: #555;
            padding: 10px 16px;
            font-size: 16px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Добавить новость</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Заголовок" required>
        <textarea name="news_text" rows="4" placeholder="Текст новости" required></textarea>
        <input type="text" name="image" placeholder="Ссылка на картинку" required>
        <input type="submit" value="Добавить">
    </form>

    <h1>Поиск новостей</h1>
    <form class="search-form" method="get">
        <input type="text" name="search" placeholder="Поиск по имени..." value="<?= htmlspecialchars($search) ?>">
        <input type="submit" value="Найти">
    </form>

    <h1>Список новостей</h1>
    <?php
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="news-item">';
            echo '<h2>' . $row['name'] . '</h2>';
            echo '<p>' . $row['news_text'] . '</p>';
            if (!empty($row['image'])) {
                echo '<img src="' . $row['image'] . '" alt="image">';
            }
            echo '</div>';
        }
    } else {
        echo "<p>Ошибка запроса: " . $mysqli->error . "</p>";
    }
    ?>
</div>
</body>
</html>
