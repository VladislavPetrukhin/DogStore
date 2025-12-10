<?php
require_once __DIR__ . '/config.php';
require_login();

$stmt = $pdo->query("SELECT d.*, b.name AS breed_name
                     FROM dogs d
                     LEFT JOIN breeds b ON d.breed_id = b.id
                     ORDER BY d.created_at DESC");
$dogs = $stmt->fetchAll();

include __DIR__ . '/header.php';
?>
<h1 style="margin-bottom:16px;">Собаки</h1>

<div class="table-wrapper">
    <div class="table-wrapper-heading">
        <div class="table-wrapper-title">Каталог собак</div>
        <div class="table-actions">
            <a href="dogs_add.php" class="btn btn-secondary">+ Добавить собаку</a>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Фото</th>
                <th>Имя</th>
                <th>Порода</th>
                <th>Цена</th>
                <th>Создано</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$dogs): ?>
            <tr><td colspan="7">Пока нет собак в каталоге.</td></tr>
        <?php else: ?>
            <?php foreach ($dogs as $d): ?>
                <tr>
                    <td><?php echo (int)$d['id']; ?></td>
                    <td>
                        <?php if (!empty($d['main_photo'])): ?>
                            <img src="uploads/dogs/<?php echo h($d['main_photo']); ?>" alt="" style="width:56px;height:56px;object-fit:cover;border-radius:10px;">
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                    <td><?php echo h($d['name']); ?></td>
                    <td><?php echo h($d['breed_name'] ?? '—'); ?></td>
                    <td><?php echo h($d['price']); ?></td>
                    <td><?php echo h($d['created_at']); ?></td>
                    <td>
                        <a class="btn btn-secondary" href="dogs_edit.php?id=<?php echo (int)$d['id']; ?>">Изменить</a>
                        <a class="btn btn-danger" href="dogs_delete.php?id=<?php echo (int)$d['id']; ?>" onclick="return confirm('Удалить эту собаку?');">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
