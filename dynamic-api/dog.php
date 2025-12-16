<?php

require_once __DIR__ . '/../dogpanel/config.php';

header('Content-Type: application/json; charset=utf-8');

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid id'], JSON_UNESCAPED_UNICODE);
  exit;
}

$sql = "
SELECT
  d.id,
  d.name,
  d.price,
  d.age,
  d.description,
  d.main_photo,
  d.breed_id,
  b.name AS breed
FROM dogs d
LEFT JOIN breeds b ON b.id = d.breed_id
WHERE d.id = :id
LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$dog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dog) {
  http_response_code(404);
  echo json_encode(['error' => 'Dog not found'], JSON_UNESCAPED_UNICODE);
  exit;
}

echo json_encode($dog, JSON_UNESCAPED_UNICODE);
