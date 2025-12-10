<?php
require_once __DIR__ . '/config.php';

// Fetch photos
$stmt = $pdo->query("SELECT * FROM gallery_photos ORDER BY uploaded_at DESC");
$photos = $stmt->fetchAll();
?>

<?php include 'header.php'; ?>

<div class="admin-container">
    <h1 class="admin-title">Галерея фото</h1>

    <a href="gallery_add.php" class="btn btn-green">➕ Добавить фото</a>

    <table class="admin-table mt-3">
        <tr>
            <th>Фото</th>
            <th>Дата</th>
            <th>Действие</th>
        </tr>

        <?php foreach ($photos as $p): ?>
        <tr>
            <td>
                <img src="uploads/gallery/<?= $p['filename'] ?>" 
                     style="width:120px; height:90px; object-fit:cover; border-radius:6px;">
            </td>
            <td><?= $p['uploaded_at'] ?></td>
            <td>
                <a href="gallery_delete.php?id=<?= $p['id'] ?>" 
                   class="btn btn-red"
                   onclick="return confirm('Удалить фото?');">Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'footer.php'; ?>
