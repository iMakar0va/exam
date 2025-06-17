<?php
require "../conn.php";
if (!isset($_GET['app_id'])) {
    header("Location: admin.php");
    exit;
}

$app_id = intval($_GET['app_id']);

$delete_app = "DELETE from applications where application_id=$1";
$res = pg_query_params($conn, $delete_app, [$app_id]);

if ($res) {
    header("Location: ../admin.php");
    exit;
}
