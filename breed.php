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

function render_maybe_html($s) {
  $s = (string)$s;
  if ($s === '') return '';
  // если похоже на HTML — рендерим как есть
  if (strpos($s, '<') !== false && strpos($s, '>') !== false) return $s;
  // иначе как текст
  return '<p>' . nl2br(h($s)) . '</p>';
}

$id   = (int)($_GET['id'] ?? 0);
$slug = trim($_GET['slug'] ?? '');

$cols = ['id', 'name'];
$optional = ['slug', 'image_url', 'short_desc', 'content_html', 'description', 'description_html'];
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

$where = '';
$params = [];

if ($slug !== '' && has_col($pdo, 'breeds', 'slug')) {
  $where = "WHERE b.slug = :slug";
  $params[':slug'] = $slug;
} else {
  $where = "WHERE b.id = :id";
  $params[':id'] = $id;
}

$stmt = $pdo->prepare("SELECT $select FROM breeds b $where LIMIT 1");
$stmt->execute($params);
$breed = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$breed) {
  http_response_code(404);
  echo "<main class='py-5'><div class='container'><h1 class='h2'>Порода не найдена</h1></div></main>";
  require_once __DIR__ . '/footer.php';
  echo "</body></html>";
  exit;
}

$name  = !empty($breed['name']) ? $breed['name'] : 'Порода';
$image = !empty($breed['image_url']) ? $breed['image_url'] : 'assets/img/no-photo.png';

$short = !empty($breed['short_desc']) ? $breed['short_desc'] : '';
$full  = '';
if (!empty($breed['content_html'])) $full = $breed['content_html'];
else if (!empty($breed['description_html'])) $full = $breed['description_html'];
else if (!empty($breed['description'])) $full = $breed['description'];
?>

<main>
  <section class="py-5">
    <div class="container">
      <h1 class="h2 mb-3"><?= h($name) ?></h1>

      <div class="row g-4">
        <div class="col-md-7">
          <article class="card p-3">
            <section class="mb-4">
              <h2 class="h5">Кратко о породе</h2>
              <?php if ($short !== ''): ?>
                <p><?= h($short) ?></p>
              <?php else: ?>
                <p class="text-muted">Короткое описание пока не добавлено.</p>
              <?php endif; ?>
            </section>

            <section class="mb-2">
              <h2 class="h5">Описание</h2>
              <?php if ($full !== ''): ?>
                <?= render_maybe_html($full) ?>
              <?php else: ?>
                <p class="text-muted">Полное описание пока не добавлено (его стоит хранить в БД).</p>
              <?php endif; ?>
            </section>
          </article>
        </div>

        <div class="col-md-5">
          <aside class="card p-3">
            <img class="img-fluid rounded-3 mb-3" src="<?= h($image) ?>" alt="<?= h($name) ?>">
            <p class="small text-muted">Подсказка: в каталоге можно искать по названию породы.</p>
            <a href="catalog.php?q=<?= urlencode($name) ?>" class="btn btn-neon w-100">Посмотреть собак</a>
          </aside>
        </div>
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
