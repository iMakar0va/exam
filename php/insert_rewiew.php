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
$data = json_decode(file_get_contents("php://input"), true);

$app_id = validate($data['app_id']);
$rewiew = validate($data['rewiew']);


$insert_query = "UPDATE applications set review=$1 where application_id=$2";
$result = pg_query_params($conn, $insert_query, [$rewiew, $app_id]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при добавлении отзыва']);
}
pg_close($conn);
