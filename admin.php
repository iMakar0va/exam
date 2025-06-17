<?php
session_start();
require('conn.php');

if (!isset($_SESSION['is_admin'])) {
    header("Location: auth.php");
    exit;
}

$get_apps = "SELECT * from applications a join users u on u.user_id = a.user_id order by date desc,time desc, application_id DESC;";
$result = pg_query_params($conn, $get_apps, []);

$applications = pg_fetch_all($result) ?: [];
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
                <div class="text">Администратор</div>
                <a href="logout.php">Выйти</a>
            </div>
        </header>
        <main>
            <div class="">
                <h2>Список всех заявок</h2>
            </div>
            <?php if (empty($applications)): ?>
                <p>В базе данных нет заявок</p>
            <?php else: ?>
                <div class="cards">
                    <?php foreach ($applications as $app): ?>
                        <div class="card" data-id="<?= $app['application_id'] ?>">
                            <a href="php/delete_app.php?app_id=<?= htmlspecialchars($app['application_id']) ?>" class="delete">Удалить заявку</a>
                            <div class="card_id">#<?= htmlspecialchars($app['application_id']) ?></div>
                            <div class="text"><b>Заявитель:</b> <?= htmlspecialchars($app['last_name']) . " " .  htmlspecialchars($app['first_name']) ?></div>
                            <div class="text"><b>Дата перевозки:</b> <?= htmlspecialchars($app['date']) ?></div>
                            <div class="text"><b>Время перевозки:</b> <?= htmlspecialchars($app['time']) ?></div>
                            <div class="text"><b>Вес груза:</b> <?= htmlspecialchars($app['weight']) ?></div>
                            <div class="text"><b>Габариты груза:</b> <?= htmlspecialchars($app['dimensions']) ?></div>
                            <div class="text"><b>Адрес отправления:</b> <?= htmlspecialchars($app['address_from']) ?></div>
                            <div class="text"><b>Адрес доставки:</b> <?= htmlspecialchars($app['address_to']) ?></div>
                            <div class="text"><b>Тип груза:</b> <?= htmlspecialchars($app['type']) ?></div>
                            <div class="text status" id="status"><b>Текущий статус:</b> <?= htmlspecialchars($app['status']) ?></div>
                            <div class="text" <?php $app['status'] !== "отменено" ? "style='display:none;'" : "" ?>><b>Комментарий:</b> </div>
                            <div class="text"><b>Новый статус:</b></div>
                            <div class="status_group">
                                <!-- <label>
                                    <input type="radio" name="status_<?= $app['application_id'] ?>" value="в работе" <?= $app['status'] == 'в работе' ? 'checked' : '' ?>>В работе
                                </label> -->
                                <label>
                                    <input type="radio" name="status_<?= $app['application_id'] ?>" value="выполнено">выполнено
                                </label>
                                <label>
                                    <input type="radio" name="status_<?= $app['application_id'] ?>" value="отменено">отменено
                                </label>
                                <textarea name="reason-input" id="reason-input" cols="20" rows="3" placeholder="Укажите причину" style="display: none"></textarea>
                                <!-- <input type="text" class="reason-input" value="<?= htmlspecialchars($app['comment']) ?>" style="display: none"> -->
                                <button type="button" id="change_status">Сохранить новый статус</button>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </main>
    </div>
    <script src="scripts/admin.js"></script>
</body>

</html>