<?php
require_once __DIR__ . '/config.php';
require_login();

$dogs_count = (int)$pdo->query("SELECT COUNT(*) FROM dogs")->fetchColumn();
$news_count = (int)$pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
$reviews_count = (int)$pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();

$last_dogs = $pdo->query("SELECT d.id, d.name, b.name AS breed_name, d.created_at
                          FROM dogs d
                          LEFT JOIN breeds b ON d.breed_id = b.id
                          ORDER BY d.created_at DESC LIMIT 5")->fetchAll();

$last_news = $pdo->query("SELECT id, title, created_at FROM news ORDER BY created_at DESC LIMIT 5")->fetchAll();

include __DIR__ . '/header.php';
?>
<h1 style="margin-bottom:16px;">Добро пожаловать, <?php echo h($_SESSION['username'] ?? 'admin'); ?>!</h1>

<div class="cards-grid">
    <div class="card">
        <div class="card-title">Собаки в каталоге</div>
        <div class="card-value"><?php echo $dogs_count; ?></div>
        <div class="card-sub">Карточки в разделе "Собаки"</div>
    </div>
    <div class="card">
        <div class="card-title">Новости</div>
        <div class="card-value"><?php echo $news_count; ?></div>
        <div class="card-sub">Записей в разделе "Новости"</div>
    </div>
    <div class="card">
        <div class="card-title">Отзывы</div>
        <div class="card-value"><?php echo $reviews_count; ?></div>
        <div class="card-sub">Сообщений в гостевой книге</div>
    </div>
</div>

<div class="table-wrapper" style="margin-top: 10px;">
    <div class="table-wrapper-heading">
        <div class="table-wrapper-title">Последние собаки</div>
        <div class="table-actions">
            <a href="dogs_add.php" class="btn btn-secondary">+ Добавить собаку</a>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Порода</th>
                <th>Создано</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$last_dogs): ?>
            <tr><td colspan="4">Пока нет записей.</td></tr>
        <?php else: ?>
            <?php foreach ($last_dogs as $d): ?>
                <tr>
                    <td><?php echo (int)$d['id']; ?></td>
                    <td><?php echo h($d['name']); ?></td>
                    <td><?php echo h($d['breed_name'] ?? '—'); ?></td>
                    <td><?php echo h($d['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="table-wrapper" style="margin-top: 16px;">
    <div class="table-wrapper-heading">
        <div class="table-wrapper-title">Последние новости</div>
        <div class="table-actions">
            <a href="news_add.php" class="btn btn-secondary">+ Добавить новость</a>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Создано</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$last_news): ?>
            <tr><td colspan="3">Пока нет новостей.</td></tr>
        <?php else: ?>
            <?php foreach ($last_news as $n): ?>
                <tr>
                    <td><?php echo (int)$n['id']; ?></td>
                    <td><?php echo h($n['title']); ?></td>
                    <td><?php echo h($n['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
