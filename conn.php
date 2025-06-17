<?php

$host = "localhost";
$port = "5432";
$user = "postgres";
$dbname = "shipping";
$password = "123";

$conn = pg_connect("host=$host port=$port user=$user dbname=$dbname password=$password");

if (!$conn) {
    die("Ошибка" . pg_last_error());
}
