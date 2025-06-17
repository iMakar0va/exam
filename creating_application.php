<?php
session_start();
require('conn.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$get_user = "SELECT * from users where user_id=$1";
$res_user = pg_query_params($conn, $get_user, [$user_id]);
$user = pg_fetch_assoc($res_user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/media_main.css">
    <title>Создание заявки</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Грузовозофф</h1>
            <div class="block">
                <p><?= htmlspecialchars($user['last_name']) . " " . htmlspecialchars($user['first_name']) ?></p>
                <a href="logout.php">Выйти</a>
            </div>
        </header>
        <div class="title">
            <a href="#!" onclick="history.back(); return false;">&#8592 Назад в личный кабинет</a>
        </div>

        <form id="createForm">
            <h2>Создание заявки</h2>
            <label for="date">Дата перевозки*:</label>
            <input type="date" id="date" name="date">
            <label for="time">Время перевозки*:</label>
            <input type="time" id="time" name="time">
            <label for="weight">Вес груза (приблизительный)*:</label>
            <input type="text" id="weight" name="weight">
            <label for="dimensions">Габариты груза*:</label>
            <input type="text" id="dimensions" name="dimensions">
            <label for="address_from">Адрес отправления*:</label>
            <input type="text" id="address_from" name="address_from">
            <label for="address_to">Адрес доставки*:</label>
            <input type="text" id="address_to" name="address_to">
            <label for="type">Тип груза*:</label>
            <select name="type" id="type">
                <option value="">--Выберете тип --</option>
                <option value="хрупкое">хрупкое</option>
                <option value="скоропортящееся">скоропортящееся</option>
                <option value="животное">животное</option>
            </select>
            <div class="box">
                <input type="checkbox" name="checkbox" id="checkbox">
                <label for="checkbox">Иной тип</label>
            </div>
            <textarea name="otherType" id="otherType" cols="30" rows="10" style="display: none;"></textarea>
            <p>* - обязательные поля</p>
            <div id="errorMessage"></div>
            <button type="submit">Создать</button>
        </form>
    </div>
    <script src="scripts/create_appplication.js"></script>
</body>

</html>