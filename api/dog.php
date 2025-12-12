<?php
require_once __DIR__ . '/../server/config.php';

header('Content-Type: application/json; charset=utf-8');

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['error' => 'Invalid ID']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM dogs WHERE id = ?");
$stmt->execute([$id]);
$dog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dog) {
    echo json_encode(['error' => 'Dog not found']);
    exit;
}

echo json_encode([
    'ok' => true,
    'dog' => $dog
]);
