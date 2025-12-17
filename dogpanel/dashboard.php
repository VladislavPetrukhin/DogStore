<?php
require_once __DIR__ . '/config.php';
require_login();

$dogs_count = (int)$pdo->query("SELECT COUNT(*) FROM dogs")->fetchColumn();
$news_count = (int)$pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
$reviews_count = (int)$pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();

$last_dogs = $pdo->query("
    SELECT d.id, d.name, b.name AS breed_name, d.created_at
    FROM dogs d
    LEFT JOIN breeds b ON d.breed_id = b.id
    ORDER BY d.created_at DESC
    LIMIT 5
")->fetchAll();

$last_news = $pdo->query("
    SELECT id, title, created_at
    FROM news
    ORDER BY created_at DESC
    LIMIT 5
")->fetchAll();

include __DIR__ . '/header.php';
?>

<h1 style="margin-bottom:16px;">
  Добро пожаловать, <?= h($_SESSION['username'] ?? 'admin'); ?>!
</h1>

<div class="cards-grid">
  <div class="card">
    <div class="card-title">Собаки в каталоге</div>
    <div class="card-value"><?= $dogs_count ?></div>
    <div class="card-sub">Карточки в разделе "Собаки"</div>
  </div>

  <div class="card">
    <div class="card-title">Новости</div>
    <div class="card-value"><?= $news_count ?></div>
    <div class="card-sub">Записей в разделе "Новости"</div>
  </div>

  <div class="card">
    <div class="card-title">Отзывы</div>
    <div class="card-value"><?= $reviews_count ?></div>
    <div class="card-sub">Сообщений в гостевой книге</div>
  </div>
</div>
<div class="form-card" style="margin-bottom:24px;">
  <h3 style="margin-bottom:12px;">Добавить собаку (AJAX)</h3>

  <div class="form-row">
    <label>Имя</label>
    <input id="newName" class="input">
  </div>

  <div class="form-row">
    <label>Цена</label>
    <input id="newPrice" type="number" min="0" class="input">
  </div>

  <div class="form-row">
    <label>Описание</label>
    <textarea id="newDesc" class="input"></textarea>
  </div>

  <div class="form-actions">
    <button class="btn" id="addDogBtn">Добавить</button>
  </div>

  <div id="addErr" class="alert alert-error" style="display:none;"></div>
</div>

<div class="table-wrapper" style="margin-top: 16px;">
  <div class="table-wrapper-heading">
    <div class="table-wrapper-title">Последние собаки</div>
    <!-- Кнопку +Добавить собаку убрали: выше есть форма AJAX -->
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Порода</th>
        <th>Создано</th>
        <th>Действия (AJAX)</th>
      </tr>
    </thead>

    <tbody id="dogsBody">
    <?php if (!$last_dogs): ?>
      <tr>
        <td colspan="5">Пока нет записей.</td>
      </tr>
    <?php else: ?>
      <?php foreach ($last_dogs as $d): ?>
        <tr>
          <td><?= (int)$d['id'] ?></td>
          <td><?= h($d['name']) ?></td>
          <td><?= h($d['breed_name'] ?? '—') ?></td>
          <td><?= h($d['created_at']) ?></td>
          <td>
            <button
              class="btn btn-sm btn-outline-info me-2"
              data-act="edit"
              data-id="<?= (int)$d['id'] ?>">
              Редактировать
            </button>

            <button
              class="btn btn-sm btn-outline-danger"
              data-act="del"
              data-id="<?= (int)$d['id'] ?>">
              Удалить
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>

<div class="table-wrapper" style="margin-top: 24px;">
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
      <tr>
        <td colspan="3">Пока нет новостей.</td>
      </tr>
    <?php else: ?>
      <?php foreach ($last_news as $n): ?>
        <tr>
          <td><?= (int)$n['id'] ?></td>
          <td><?= h($n['title']) ?></td>
          <td><?= h($n['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- МОДАЛКА РЕДАКТИРОВАНИЯ -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="background:#111;color:#fff">
      <div class="modal-header">
        <h5 class="modal-title">Редактировать собаку (AJAX)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="editId">

        <div class="form-row">
          <label>Имя</label>
          <input class="input" id="editName">
        </div>

        <div class="form-row">
          <label>Цена</label>
          <input class="input" id="editPrice" type="number" min="0">
        </div>

        <div class="form-row">
          <label>Описание</label>
          <textarea class="input" id="editDesc" rows="5"></textarea>
        </div>

        <div id="editErr"
             class="error"
             style="display:none;color:#ff7b7b;margin-top:8px;">
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
        <button class="btn btn-primary" id="saveBtn">Сохранить (AJAX)</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/ajax-dashboard.js"></script>

<?php include __DIR__ . '/footer.php'; ?>
