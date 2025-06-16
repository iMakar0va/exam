<?php
session_start();
require('conn.php');

if (!isset($_SESSION['user_id'])) {
    // Если не авторизован - перенаправляем на страницу входа
    header('Location: login.php');
    exit(); // Важно завершить выполнение скрипта
}

$user_id = $_SESSION['user_id'];

$get_apps = "SELECT * from applications where user_id =$1 order by date desc;";
$result = pg_query_params($conn, $get_apps, [$user_id]);

$applications = pg_fetch_all($result) ?: [];

$get_user = "SELECT * from users where user_id=$1";
$res_user = pg_query_params($conn, $get_user, [$user_id]);
$user_name = pg_fetch_assoc($res_user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/media_main.css">
    <title>Личный кабинет</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Мой не сам</h1>
            <div class="block">
                <p><?php echo $user_name['last_name'] . " " . $user_name['first_name'] ?></p>
                <a href="logout.php">Выйти</a>
            </div>
        </header>
        <main>
            <div class="title">
                <h2>Список всех заявок</h2>
                <a href="creating_application.php">Создать заявку</a>
            </div>
            <?php if (empty($applications)): ?>
                <p>У вас нет заявок</p>
            <?php else: ?>
                <div class="cards">
                    <?php foreach ($applications as $app): ?>
                        <div class="card">
                            <div class="card_id">#<?= htmlspecialchars($app['application_id']) ?></div>
                            <div class="text"><b>Адрес:</b> <?= htmlspecialchars($app['address']) ?></div>
                            <div class="text"><b>Телефон:</b> <?= htmlspecialchars($app['application_phone']) ?></div>
                            <div class="text"><b>Услуга:</b> <?= htmlspecialchars($app['service']) ?></div>
                            <div class="text"><b>Дата:</b> <?= htmlspecialchars($app['date']) ?></div>
                            <div class="text"><b>Оплата:</b> <?= htmlspecialchars($app['payment']) ?></div>
                            <div class="text"><b>Статус:</b> <?= htmlspecialchars($app['status']) ?></div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</body>

</html>