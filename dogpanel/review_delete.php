<?php
require_once __DIR__ . '/config.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
$stmt->execute([$id]);

header("Location: reviews.php");
exit;
