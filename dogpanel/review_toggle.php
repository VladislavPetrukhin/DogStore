<?php
require_once __DIR__ . '/config.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$approved = isset($_GET['approved']) ? (int)$_GET['approved'] : 0;

$stmt = $pdo->prepare("UPDATE reviews SET approved = ? WHERE id = ?");
$stmt->execute([$approved ? 1 : 0, $id]);

header("Location: reviews.php");
exit;
