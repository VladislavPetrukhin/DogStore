<?php
require_once __DIR__ . '/../../server/config.php';
header('Content-Type: application/json; charset=utf-8');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  json_out(['ok' => false, 'error' => 'Method not allowed'], 405);
}

if (empty($_FILES['photo']) || !is_uploaded_file($_FILES['photo']['tmp_name'])) {
  json_out(['ok' => false, 'error' => 'Файл не найден'], 400);
}

$dir = __DIR__ . '/../../dogpanel/uploads/gallery/';
if (!is_dir($dir)) {
  mkdir($dir, 0777, true);
}

$orig = (string)($_FILES['photo']['name'] ?? '');
$ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
$allowed = ['jpg','jpeg','png','webp','gif'];
if ($ext === '' || !in_array($ext, $allowed, true)) {
  json_out(['ok' => false, 'error' => 'Разрешены: jpg/jpeg/png/webp/gif'], 400);
}

$name = 'gallery_' . time() . '_' . random_int(1000, 9999) . '.' . $ext;
$target = $dir . $name;

if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
  json_out(['ok' => false, 'error' => 'Ошибка загрузки'], 500);
}

$stmt = $pdo->prepare("INSERT INTO gallery_photos (filename) VALUES (?)");
$stmt->execute([$name]);
$id = (int)$pdo->lastInsertId();

// Берём дату из БД, чтобы в таблице было красиво
$row = $pdo->prepare('SELECT id, filename, uploaded_at FROM gallery_photos WHERE id=?');
$row->execute([$id]);
$p = $row->fetch() ?: ['id' => $id, 'filename' => $name, 'uploaded_at' => date('Y-m-d H:i:s')];

json_out(['ok' => true, 'photo' => $p]);
