<?php
session_start();
require('conn.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit;
}


if (!isset($_GET['app_id'])) {
    header("Location: auth.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$app_id = intval($_GET['app_id']);

$check_app = "SELECT * from applications where user_id=$1 and application_id=$2";
$res_app = pg_query_params($conn, $check_app, [$user_id, $app_id]);
if (pg_num_rows($res_app) == 0) {
    header("Location: auth.php");
    exit;
}
$app = pg_fetch_assoc($res_app);

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
    <title>Отзыв заявки</title>
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

        <form id="rewiewForm">
            <h2>Оставить отзыв</h2>
            <input type="hidden" name="app_id" value="<?= htmlspecialchars($app['application_id']) ?>">
            <p><b>Номер заявки: </b><?= htmlspecialchars($app['application_id']) ?></p>
            <p><b>Дата перевозки: </b><?= htmlspecialchars($app['date']) ?></p>
            <p><b>Тип груза: </b><?= htmlspecialchars($app['type']) ?></p>
            <label for="rewiew"><b>Отзыв:</b></label>
            <textarea name="rewiew" id="rewiew" cols="30" rows="10" required></textarea>
            <p>* - обязательные поля</p>
            <div id="errorMessage"></div>
            <button type="submit">Создать</button>
        </form>
    </div>
    <script src="scripts/rewiew.js"></script>
</body>

</html>