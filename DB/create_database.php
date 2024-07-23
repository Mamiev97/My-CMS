<?php

$config = require '../App/config/connection.php';

try {
    $conn = new PDO("mysql:host={$config['db_host']}", $config['db_user'], $config['db_pass']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS {$config['db_name']}";
    $conn->exec($sql);
    echo "База данных успешно создана\n";
} catch(PDOException $e) {
    echo "Ошибка при создании базы данных: " . $e->getMessage();
    exit();
}

try {
    $conn = new PDO("mysql:host={$config['db_host']};dbname={$config['db_name']}", $config['db_user'], $config['db_pass']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $usersTable = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        last_name TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        email VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        password VARCHAR(350) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        role TINYINT UNSIGNED NULL DEFAULT NULL,
        date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        date_update DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
    $conn->exec($usersTable);
    echo "Таблица 'users' успешно создана\n";
} catch(PDOException $e) {
    echo "Ошибка при создании таблицы: " . $e->getMessage();
    exit();
} finally {
    $conn = null;
}
