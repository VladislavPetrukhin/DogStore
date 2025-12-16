<?php
require_once __DIR__ . '/dogpanel/config.php';
require_once __DIR__ . '/head.php';
require_once __DIR__ . '/header.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
  die('PDO не инициализирован. Проверь dogpanel/config.php');
}

function has_col(PDO $pdo, $table, $col) {
  $db = $pdo->query("SELECT DATABASE()")->fetchColumn();
  $st = $pdo->prepare("
    SELECT 1
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :t AND COLUMN_NAME = :c
    LIMIT 1
  ");
  $st->execute([
    ':db' => $db,
    ':t'  => $table,
    ':c'  => $col,
  ]);
  return (bool)$st->fetchColumn();
}

$cols = ['id', 'name'];

$optional = ['slug', 'image_url', 'short_desc'];
foreach ($optional as $c) {
  if (has_col($pdo, 'breeds', $c)) {
    $cols[] = $c;
  }
}

$selectCols = [];
foreach ($cols as $c) {
  $selectCols[] = "b.`$c`";
}
$select = implode(', ', $selectCols);

$stmt = $pdo->query("SELECT $select FROM breeds b ORDER BY b.name");
$breeds = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
  <section class="py-5">
    <div class="container">
      <h1 class="h2 mb-4">Энциклопедия пород</h1>

      <div class="row g-4">
        <?php if (!$breeds): ?>
          <div class="col-12">
            <div class="alert alert-warning">
              В таблице <b>breeds</b> пока пусто — добавь породы и обнови страницу.
            </div>
          </div>
        <?php endif; ?>

        <?php foreach ($breeds as $b): ?>
          <?php
            $name  = isset($b['name']) ? $b['name'] : 'Порода';
            $img   = !empty($b['image_url']) ? $b['image_url'] : 'assets/img/no-photo.png';
            $short = !empty($b['short_desc']) ? $b['short_desc'] : 'Описание пока не добавлено.';

            $link = 'breed.php?id=' . urlencode((string)$b['id']);
            if (!empty($b['slug'])) {
              $link = 'breed.php?slug=' . urlencode((string)$b['slug']);
            }
          ?>
          <div class="col-12 col-sm-6 col-lg-4">
            <article class="card shadow-neon h-100">
              <img src="<?= h($img) ?>" class="card-img-top img-fluid" alt="Порода <?= h($name) ?>">
              <div class="card-body">
                <h3 class="card-title h5"><?= h($name) ?></h3>
                <p class="card-text"><?= h($short) ?></p>
                <a href="<?= h($link) ?>" class="btn btn-sm btn-neon">Подробнее</a>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const y = document.getElementById('year');
    if (y) y.textContent = new Date().getFullYear();
  });
</script>
</body>
</html>
