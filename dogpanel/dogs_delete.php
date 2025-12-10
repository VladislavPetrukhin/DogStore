<?php
require_once __DIR__ . '/config.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT main_photo FROM dogs WHERE id = ?");
$stmt->execute([$id]);
$dog = $stmt->fetch();

if ($dog) {
    if (!empty($dog['main_photo']) && is_file(__DIR__ . '/uploads/dogs/' . $dog['main_photo'])) {
        @unlink(__DIR__ . '/uploads/dogs/' . $dog['main_photo']);
    }
    $del = $pdo->prepare("DELETE FROM dogs WHERE id = ?");
    $del->execute([$id]);
}

header("Location: dogs.php");
exit;
