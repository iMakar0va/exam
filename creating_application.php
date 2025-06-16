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
            <h1>Мой не сам</h1>
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
            <label for="date">Дата*:</label>
            <input type="date" id="date" name="date">
            <label for="time">Время*:</label>
            <input type="time" id="time" name="time">
            <label for="address">Адрес*:</label>
            <input type="text" id="address" name="address">
            <label for="phone">Телефон*:</label>
            <input type="text" id="phone" name="phone">
            <label for="service">Услуга*:</label>
            <select name="service" id="service">
                <option value="">--Выберете услугу--</option>
                <option value="Стирка">Стирка</option>
                <option value="Уборка">Уборка</option>
                <option value="Мойка">Мойка</option>
            </select>
            <div class="box">
                <input type="checkbox" name="checkbox" id="checkbox">
                <label for="checkbox">Иная услуга</label>
            </div>
            <textarea name="otherService" id="otherService" cols="30" rows="10" style="display: none;"></textarea>
            <label for="payment">Оплата*:</label>
            <select name="payment" id="payment">
                <option value="">--Выберете тип оплаты--</option>
                <option value="наличные">наличные</option>
                <option value="банковская карта">банковская карта</option>
            </select>
            <p>* - обязательные поля</p>
            <div id="errorMessage"></div>
            <button type="submit">Создать</button>
        </form>
    </div>
    <script src="scripts/create_appplication.js"></script>
</body>

</html>