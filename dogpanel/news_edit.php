<?php
require_once __DIR__ . '/config.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    die('Новость не найдена.');
}

$errors = [];
$title = trim($_POST['title'] ?? $news['title']);
$body = trim($_POST['body'] ?? $news['body']);
$current_image = $news['image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($title === '' || !preg_match('/^.{3,200}$/u', $title)) {
        $errors[] = 'Заголовок должен быть от 3 до 200 символов.';
    }

    if (!empty($_FILES['image']['name'])) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $type = mime_content_type($_FILES['image']['tmp_name']);
        if (!isset($allowed[$type])) {
            $errors[] = 'Разрешены только JPG, PNG или WEBP.';
        } else {
            $ext = $allowed[$type];
            $image_name = 'news_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $dest = __DIR__ . '/uploads/news/' . $image_name;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                $errors[] = 'Не удалось сохранить изображение.';
            } else {
                if ($current_image && is_file(__DIR__ . '/uploads/news/' . $current_image)) {
                    @unlink(__DIR__ . '/uploads/news/' . $current_image);
                }
                $current_image = $image_name;
            }
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare("UPDATE news SET title = ?, body = ?, image = ? WHERE id = ?");
        $stmt->execute([$title, $body !== '' ? $body : null, $current_image, $id]);
        header("Location: news.php");
        exit;
    }
}

include __DIR__ . '/header.php';
?>
<h1 style="margin-bottom:16px;">Редактировать новость</h1>

<?php if ($errors): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?>
            <div><?php echo h($e); ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="form-card">
    <div class="form-row">
        <label for="title">Заголовок *</label>
        <input type="text" id="title" name="title" value="<?php echo h($title); ?>">
    </div>
    <div class="form-row">
        <label for="body">Текст новости</label>
        <textarea id="body" name="body"><?php echo h($body); ?></textarea>
    </div>
    <div class="form-row">
        <label for="image">Новое изображение (если нужно заменить)</label>
        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
        <?php if ($current_image): ?>
            <div style="margin-top:8px;">
                <span style="font-size:12px;color:#9f9fd0;">Текущее изображение:</span><br>
                <img src="uploads/news/<?php echo h($current_image); ?>" alt="" style="width:160px;height:100px;object-fit:cover;border-radius:10px;margin-top:4px;">
            </div>
        <?php endif; ?>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn">Сохранить</button>
        <a href="news.php" class="btn btn-secondary">Отмена</a>
    </div>
</form>

<?php include __DIR__ . '/footer.php'; ?>
