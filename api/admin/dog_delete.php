<?php
require_once __DIR__ . '/../../server/config.php';
header('Content-Type: application/json; charset=utf-8');


$data = read_json();
$id = (int)($data['id'] ?? 0);
if ($id <= 0) json_out(['ok'=>false,'error'=>'Bad id'], 400);

$stmt = $pdo->prepare("DELETE FROM dogs WHERE id = ?");
$stmt->execute([$id]);

json_out(['ok'=>true]);
