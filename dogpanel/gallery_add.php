<?php
require_once __DIR__ . '/config.php';
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['photo']['name'])) {

        $dir = __DIR__ . '/uploads/gallery/';
        if (!file_exists($dir)) mkdir($dir, 0777, true);

        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $name = 'gallery_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
        $target = $dir . $name;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $stmt = $pdo->prepare("INSERT INTO gallery_photos (filename) VALUES (?)");
            $stmt->execute([$name]);
            $msg = "Фото успешно загружено!";
        } else {
            $msg = "Ошибка загрузки!";
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="admin-container">
    <h1 class="admin-title">Добавить фото в галерею</h1>

    <?php if ($msg): ?>
        <p class="admin-message"><?= $msg ?></p>
    <?php endif; ?>

    <form class="admin-form" method="post" enctype="multipart/form-data">
        <label>Выберите фото:</label>
        <input type="file" name="photo" required class="input-file">

        <button type="submit" class="btn btn-green">Загрузить</button>
    </form>

    <a href="gallery.php" class="btn btn-gray mt-2">Назад</a>
</div>

<?php include 'footer.php'; ?>
