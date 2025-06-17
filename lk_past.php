<?php
session_start();
require('conn.php');

if (!isset($_SESSION['user_id'])) {
    // Если не авторизован - перенаправляем на страницу входа
    header('Location: login.php');
    exit(); // Важно завершить выполнение скрипта
}

$user_id = $_SESSION['user_id'];

$get_apps = "SELECT * from applications where user_id =$1 and status='выполнено' order by date desc;";
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
            <h1>Грузовозофф</h1>
            <div class="block">
                <div class="text"><?php echo $user_name['last_name'] . " " . $user_name['first_name'] ?></div>
                <a href="logout.php">Выйти</a>
            </div>
        </header>
        <main>
            <div class="title">
                <h2>Список завершенных заявок</h2>
                <a href="lk.php">Список текущих задач</a>
            </div>
            <?php if (empty($applications)): ?>
                <p>У вас нет завершенных заявок</p>
            <?php else: ?>
                <div class="cards">
                    <?php foreach ($applications as $app): ?>
                        <div class="card">
                            <div class="card_id">#<?= htmlspecialchars($app['application_id']) ?></div>
                            <div class="text"><b>Дата перевозки:</b> <?= htmlspecialchars($app['date']) ?></div>
                            <div class="text"><b>Время перевозки:</b> <?= htmlspecialchars($app['time']) ?></div>
                            <div class="text"><b>Вес груза:</b> <?= htmlspecialchars($app['weight']) ?></div>
                            <div class="text"><b>Габариты груза:</b> <?= htmlspecialchars($app['dimensions']) ?></div>
                            <div class="text"><b>Адрес отправления:</b> <?= htmlspecialchars($app['address_from']) ?></div>
                            <div class="text"><b>Адрес доставки:</b> <?= htmlspecialchars($app['address_to']) ?></div>
                            <div class="text"><b>Тип груза:</b> <?= htmlspecialchars($app['type']) ?></div>
                            <div class="text"><b>Статус:</b> <?= htmlspecialchars($app['status']) ?></div>
                            <?php if (empty($app['review'])): ?>
                                <a href="rewiew.php?app_id=<?= htmlspecialchars($app['application_id']) ?>" class="button">Оставить отзыв</a>
                            <?php else: ?>
                                <div class="text"><b>Отзыв:</b> <?= htmlspecialchars($app['review']) ?></div>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </main>
    </div>
</body>

</html>