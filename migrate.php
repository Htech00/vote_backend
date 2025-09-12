<?php
$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$db   = getenv("DB_NAME");
$port = getenv("DB_PORT") ?: 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (getenv("RUN_MIGRATION") === "true") {
    $sqlFile = _DIR_ . "/bincom_test.sql";

    if (!file_exists($sqlFile)) {
        die("❌ SQL file not found: $sqlFile");
    }

    $queries = file_get_contents($sqlFile);

    if ($conn->multi_query($queries)) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
        echo "✅ Migration completed successfully!";
    } else {
        echo "❌ Migration failed: " . $conn->error;
    }
} else {
    echo "⚠ Migration skipped. Set RUN_MIGRATION=true to enable.";
}

$conn->close();