<?php
$host = getenv("DB_HOST") ?: "localhost";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASS") ?: "";
$db   = getenv("DB_NAME") ?: "bincom_test";
$port   = getenv("DB_PORT") ?: 33432;


$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die(json_encode(["error" => "Database connection failed: " . mysqli_connect_error()]));
}
?>