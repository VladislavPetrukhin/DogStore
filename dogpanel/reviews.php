<?php
require_once __DIR__ . '/config.php';
require_login();

$reviews = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC")->fetchAll();

include __DIR__ . '/header.php';
?>
<h1 style="margin-bottom:16px;">Отзывы</h1>

<div class="table-wrapper">
    <div class="table-wrapper-heading">
        <div class="table-wrapper-title">Гостевая книга / отзывы</div>
        <div class="table-actions">
            <span style="font-size:12px;color:#9f9fd0;">Управление одобрением и удалением</span>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Сообщение</th>
                <th>Дата</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$reviews): ?>
            <tr><td colspan="7">Пока нет отзывов.</td></tr>
        <?php else: ?>
            <?php foreach ($reviews as $r): ?>
                <tr>
                    <td><?php echo (int)$r['id']; ?></td>
                    <td><?php echo h($r['name']); ?></td>
                    <td><?php echo h($r['email']); ?></td>
                    <td><?php echo nl2br(h($r['message'])); ?></td>
                    <td><?php echo h($r['created_at']); ?></td>
                    <td><?php echo $r['approved'] ? 'Одобрено' : 'На модерации'; ?></td>
                    <td>
                        <?php if ($r['approved']): ?>
                            <a href="review_toggle.php?id=<?php echo (int)$r['id']; ?>&approved=0" class="btn btn-secondary">Скрыть</a>
                        <?php else: ?>
                            <a href="review_toggle.php?id=<?php echo (int)$r['id']; ?>&approved=1" class="btn btn-secondary">Одобрить</a>
                        <?php endif; ?>
                        <a href="review_delete.php?id=<?php echo (int)$r['id']; ?>" class="btn btn-danger" onclick="return confirm('Удалить отзыв?');">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
