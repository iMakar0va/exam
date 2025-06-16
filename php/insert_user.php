<?php
require "../conn.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    die('Доступ запрещен: форма должна отправляться методом POST.');
}

function validate($data)
{
    return htmlspecialchars(trim($data));
}

$last_name = validate($_POST['last_name']);
$first_name = validate($_POST['first_name']);
$father_name = validate($_POST['father_name']);
$phone = validate($_POST['phone']);
$email = validate($_POST['email']);
$login = validate($_POST['login']);
$password = validate($_POST['password']);

$hash_password = password_hash($password, PASSWORD_DEFAULT);

$check_query = "SELECT * from users where login=$1";
$result = pg_query_params($conn, $check_query, [$login]);

if (pg_num_rows($result) > 0) {
    echo json_encode(['success' => false, 'message' => 'Такой логин уже есть']);
    pg_close($conn);
    exit;
}

$insert_query = "INSERT INTO users (last_name, first_name,father_name,user_phone,email,login,password) values($1,$2,$3,$4,$5,$6,$7)";
$result = pg_query_params($conn, $insert_query, [$last_name, $first_name, $father_name, $phone, $email, $login, $hash_password]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при регистрации']);
}
pg_close($conn);
