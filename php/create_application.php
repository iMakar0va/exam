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
$weight = validate($_POST['weight']);
$dimensions = validate($_POST['dimensions']);
$address_from = validate($_POST['address_from']);
$address_to = validate($_POST['address_to']);
$type = validate($_POST['type'] ?? '');
$otherType = validate($_POST['otherType'] ?? '');

$final_type = $otherType !== '' ? $otherType : $type;
$user_id = $_SESSION['user_id'];

$insert_app = "INSERT INTO applications (user_id, date, time, weight, dimensions, address_from, address_to, type) values ($1, $2, $3, $4, $5, $6, $7, $8)";
$result = pg_query_params($conn, $insert_app, [$user_id, $date, $time, $weight, $dimensions, $address_from, $address_to, $final_type]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => "Ошибка создания заявки"]);
}

pg_close($conn);
