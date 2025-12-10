<?php
require_once __DIR__ . '/config.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT image FROM news WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if ($news) {
    if (!empty($news['image']) && is_file(__DIR__ . '/uploads/news/' . $news['image'])) {
        @unlink(__DIR__ . '/uploads/news/' . $news['image']);
    }
    $del = $pdo->prepare("DELETE FROM news WHERE id = ?");
    $del->execute([$id]);
}

header("Location: news.php");
exit;
