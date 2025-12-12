<?php
require_once __DIR__ . '/config.php';
require_login();

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT filename FROM gallery_photos WHERE id=?");
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetch();

    if ($row) {
        $file = __DIR__ . '/uploads/gallery/' . $row['filename'];
        if (file_exists($file)) unlink($file);

        $stmt = $pdo->prepare("DELETE FROM gallery_photos WHERE id=?");
        $stmt->execute([$_GET['id']]);
    }
}

header("Location: gallery.php");
exit;
?>