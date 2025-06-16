<?php
require '../conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    die('Доступ запрещен: форма должна отправляться методом POST.');
}
function validate($data)
{
    return htmlspecialchars(trim($data));
}

$date = validate($_POST['date']);
$time = validate($_POST['time']);
$address = validate($_POST['address']);
$phone = validate($_POST['phone']);
$service = validate($_POST['service'] ?? '');
$otherService = validate($_POST['otherService'] ?? '');
$payment = validate($_POST['payment']);

$final_service = $otherService !== '' ? $otherService : $service;
$user_id = $_SESSION['user_id'];

$insert_app = "INSERT INTO applications (user_id, service, application_phone, date, time, address, payment) values ($1, $2, $3, $4, $5, $6, $7)";
$result = pg_query_params($conn, $insert_app, [$user_id, $final_service, $phone, $date, $time, $address, $payment]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => "Ошибка создания заявки"]);
}

pg_close($conn);
