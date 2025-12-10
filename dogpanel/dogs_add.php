<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/breeds_helper.php';
require_login();

$errors = [];
$name = trim($_POST['name'] ?? '');
$breed_id = trim($_POST['breed_id'] ?? '');
$age = trim($_POST['age'] ?? '');
$price = trim($_POST['price'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($name === '' || !preg_match('/^[\p{L}0-9\s\-]{2,50}$/u', $name)) {
        $errors[] = 'Введите корректное имя собаки (2–50 символов).';
    }
    if ($price !== '' && !preg_match('/^\d{1,6}(\.\d{1,2})?$/', $price)) {
        $errors[] = 'Цена должна быть числом (до 2 знаков после точки).';
    }
    if ($age !== '' && !preg_match('/^\d{1,2}$/', $age)) {
        $errors[] = 'Возраст должен быть числом (лет).';
    }

    $photo_name = null;
    if (!empty($_FILES['photo']['name'])) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $type = mime_content_type($_FILES['photo']['tmp_name']);
        if (!isset($allowed[$type])) {
            $errors[] = 'Разрешены только JPG, PNG или WEBP.';
        } else {
            $ext = $allowed[$type];
            $photo_name = 'dog_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $dest = __DIR__ . '/uploads/dogs/' . $photo_name;
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
                $errors[] = 'Не удалось сохранить загруженное фото.';
            }
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO dogs (name, breed_id, age, price, description, main_photo, created_at)
                               VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            $name,
            $breed_id !== '' ? $breed_id : null,
            $age !== '' ? $age : null,
            $price !== '' ? $price : null,
            $description !== '' ? $description : null,
            $photo_name,
        ]);

        header("Location: dogs.php");
        exit;
    }
}

$breeds = load_breeds($pdo);

include __DIR__ . '/header.php';
?>
<h1 style="margin-bottom:16px;">Добавить собаку</h1>

<?php if ($errors): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?>
            <div><?php echo h($e); ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="form-card">
    <div class="form-row">
        <label for="name">Имя *</label>
        <input type="text" id="name" name="name" value="<?php echo h($name); ?>">
    </div>
    <div class="form-row">
        <label for="breed_id">Порода</label>
        <select id="breed_id" name="breed_id">
            <option value="">— не выбрано —</option>
            <?php foreach ($breeds as $b): ?>
                <option value="<?php echo (int)$b['id']; ?>" <?php if ($breed_id == $b['id']) echo 'selected'; ?>>
                    <?php echo h($b['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-row">
        <label for="age">Возраст (лет)</label>
        <input type="number" id="age" name="age" min="0" max="30" value="<?php echo h($age); ?>">
    </div>
    <div class="form-row">
        <label for="price">Цена (число)</label>
        <input type="text" id="price" name="price" value="<?php echo h($price); ?>">
    </div>
    <div class="form-row">
        <label for="description">Описание</label>
        <textarea id="description" name="description"><?php echo h($description); ?></textarea>
    </div>
    <div class="form-row">
        <label for="photo">Фото (JPG, PNG, WEBP)</label>
        <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
    </div>
    <div class="form-actions">
        <button type="submit" class="btn">Сохранить</button>
        <a href="dogs.php" class="btn btn-secondary">Отмена</a>
    </div>
</form>

<?php include __DIR__ . '/footer.php'; ?>
