<?php
// Конфигурация подключения к базе данных DogPanel
$DB_HOST = 'localhost';
$DB_NAME = 'dogpanel';
$DB_USER = 'root';
$DB_PASS = '';

$DB_DSN = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

try {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

session_start();

function require_login() {
    if (empty($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
