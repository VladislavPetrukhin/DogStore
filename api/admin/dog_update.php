<?php
require_once __DIR__ . '/../../server/config.php';
header('Content-Type: application/json; charset=utf-8');


$data = read_json();
$id = (int)($data['id'] ?? 0);
if ($id <= 0) json_out(['ok'=>false,'error'=>'Bad id'], 400);

$name = trim($data['name'] ?? '');
$price = (int)($data['price'] ?? 0);
$desc = trim($data['description'] ?? '');

if ($name === '') json_out(['ok'=>false,'error'=>'Имя обязательно'], 400);

// Simple regex validation for lab requirement (letters/numbers/space/-)
if (!preg_match('/^[\p{L}0-9\s\-]{2,80}$/u', $name)) {
  json_out(['ok'=>false,'error'=>'Имя: только буквы/цифры/пробел/дефис (2–80)'], 400);
}

$stmt = $pdo->prepare("UPDATE dogs SET name=?, price=?, description=? WHERE id=?");
$stmt->execute([$name, $price, $desc, $id]);

json_out(['ok'=>true]);
