<?php
require_once __DIR__ . '/config.php';
require_login();

$news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();

include __DIR__ . '/header.php';
?>
<h1 style="margin-bottom:16px;">Новости</h1>

<div class="table-wrapper">
    <div class="table-wrapper-heading">
        <div class="table-wrapper-title">Список новостей</div>
        <div class="table-actions">
            <a href="news_add.php" class="btn btn-secondary">+ Добавить новость</a>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$news): ?>
            <tr><td colspan="4">Пока нет новостей.</td></tr>
        <?php else: ?>
            <?php foreach ($news as $n): ?>
                <tr>
                    <td><?php echo (int)$n['id']; ?></td>
                    <td><?php echo h($n['title']); ?></td>
                    <td><?php echo h($n['created_at']); ?></td>
                    <td>
                        <a href="news_edit.php?id=<?php echo (int)$n['id']; ?>" class="btn btn-secondary">Изменить</a>
                        <a href="news_delete.php?id=<?php echo (int)$n['id']; ?>" class="btn btn-danger" onclick="return confirm('Удалить новость?');">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
