<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список участников</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #4CAF50;
            color: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
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
        a {
          text-decoration: none;
          color: #007bff;
        }

        a:hover {
          color: #ff0000;
          font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="container">
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

        $query = "SELECT * FROM intern";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Список участников</h2>";
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li><a href='?delete_id=" . $row['id'] . "'>" . $row['name'] . " " . $row['surname'] . "</a></li>";            }
            echo "</ul>";
        } else {
            echo "<p>Нет данных в таблице.</p>";
        }
        
        mysqli_close($conn);
        ?>
        <a href="add_user.php" class="btn">Добавить участника</a>
        <a href="delete_user.php?delete_id=<?php echo $_GET['delete_id']; ?>" class="btn btn-danger">Удалить участника</a>
    </div>
</body>
</html>

