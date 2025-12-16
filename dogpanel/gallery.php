<?php
require_once __DIR__ . '/config.php';
require_login();

$stmt = $pdo->query("SELECT * FROM gallery_photos ORDER BY uploaded_at DESC");
$photos = $stmt->fetchAll();
?>

<?php include 'header.php'; ?>

<div class="admin-container">
    <h1 class="admin-title">Галерея фото</h1>

    <div class="form-card" style="margin-bottom:16px;">
      <h3 style="margin-bottom:12px;">Добавить фото (AJAX)</h3>

      <form id="galleryUploadForm" enctype="multipart/form-data">
        <div class="form-row">
          <label>Файл</label>
          <input id="galleryFile" type="file" accept="image/*" required>
        </div>

        <div class="form-actions">
          <button class="btn" type="submit">Загрузить</button>
        </div>
      </form>

      <div id="galleryErr" class="alert alert-error" style="display:none;"></div>
    </div>

    <table class="admin-table mt-3">
        <tr>
            <th>Фото</th>
            <th>Дата</th>
            <th>Действие</th>
        </tr>

        <tbody id="galleryBody">
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
        </tbody>
    </table>
</div>

<script src="assets/ajax-gallery.js"></script>

<?php include 'footer.php'; ?>
