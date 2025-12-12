<?php
require_once __DIR__ . '/../server/config.php';
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
  echo json_encode(['error' => 'No JSON received']);
  exit;
}

$stmt = $pdo->prepare(
  "INSERT INTO reviews (name, email, rating, message, created_at)
   VALUES (?, ?, ?, ?, NOW())"
);

$stmt->execute([
  trim($data['name'] ?? ''),
  trim($data['email'] ?? ''),
  (int)($data['rating'] ?? 0),
  trim($data['message'] ?? '')
]);

echo json_encode(['ok' => true]);
