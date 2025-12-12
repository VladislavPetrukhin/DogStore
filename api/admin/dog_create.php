<?php
require_once __DIR__ . '/../../server/config.php';
header('Content-Type: application/json; charset=utf-8');


$data = read_json();

$name        = trim($data['name'] ?? '');
$price       = (float)($data['price'] ?? 0);
$description = trim($data['description'] ?? '');

if ($name === '') json_out(['error' => 'Имя обязательно'], 400);

$stmt = $pdo->prepare("
    INSERT INTO dogs (name, price, description, created_at)
    VALUES (?, ?, ?, NOW())
");

$stmt->execute([$name, $price ?: null, $description ?: null]);

$id = (int)$pdo->lastInsertId();

json_out([
    'id' => $id,
    'name' => $name,
    'price' => $price,
    'description' => $description
]);
