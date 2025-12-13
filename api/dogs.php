<?php
require_once __DIR__ . '/../server/config.php';

$q = trim($_GET['q'] ?? '');
$params = [];
$sql = "SELECT d.id, d.name, b.name AS breed, d.price, d.main_photo
        FROM dogs d
        LEFT JOIN breeds b ON b.id = d.breed_id";

if ($q !== '') {
  $sql .= " WHERE d.name LIKE :q OR b.name LIKE :q";
  $params[':q'] = "%{$q}%";
}
$sql .= " ORDER BY d.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

json_out($stmt->fetchAll());
