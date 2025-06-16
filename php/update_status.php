<?php
require '../conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    die('Доступ запрещен: форма должна отправляться методом POST.');
}

header('Content-Type: application/json');

function validate($data)
{
    return htmlspecialchars(trim($data));
}
$data = json_decode(file_get_contents('php://input'), true);

$status = validate($data['status']);
$comment = validate($data['comment']);
$application_id = validate($data['application_id']);

$update_status = "UPDATE applications set status=$1, comment=$2 where application_id=$3;";
$result = pg_query_params($conn, $update_status, [$status, $comment, $application_id]);



if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Ошибка при обновлении статуса']);
}
pg_close($conn);
