<?php
// Общая конфигурация для /api (JSON) и dogpanel.
// Подключаем тот же PDO + сессию, что и в dogpanel.

require_once __DIR__ . '/../dogpanel/config.php';

// Для API всегда отвечаем JSON (без HTML/редиректов)
header('Content-Type: application/json; charset=utf-8');

function json_out($data, int $code = 200): void {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function read_json(): array {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw ?: '', true);
    return is_array($data) ? $data : [];
}

function require_api_login(): void {
    if (empty($_SESSION['user_id'])) {
        json_out(['ok' => false, 'error' => 'auth'], 401);
    }
}
