<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: lk.php");
    exit;
}
if (isset($_SESSION['is_admin'])) {
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/main.css">
    <title>Регистрация</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Грузовозофф</h1>
        </header>
        <form id="regForm">
            <h2>Регистрация</h2>
            <label for="last_name">Фамилия*:</label>
            <input type="text" id="last_name" name="last_name" required>
            <label for="first_name">Имя*:</label>
            <input type="text" id="first_name" name="first_name" required>
            <label for="father_name">Отчество*:</label>
            <input type="text" id="father_name" name="father_name" required>
            <label for="phone">Номер телефона*:</label>
            <input type="text" id="phone" name="phone" placeholder="+7 (XXX) XXX-XX-XX" required>
            <label for="email">Почта*:</label>
            <input type="email" id="email" name="email" required>
            <label for="login">Логин*:</label>
            <input type="text" id="login" name="login" placeholder="не меньше 6 символов" required>
            <label for="password">Пароль*:</label>
            <input type="password" id="password" name="password" placeholder="не меньше 6 символов" required>
            <p>* - обязательные поля</p>
            <div id="errorMessage"></div>
            <button type="submit">Создать</button>
            <div class="link">
                Уже есть аккаунт? <a href="auth.php">Войти</a>
            </div>
        </form>
    </div>
    <script src="scripts/reg.js"></script>
</body>

</html>