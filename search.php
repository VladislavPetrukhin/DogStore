<?php
require_once __DIR__ . '/dogpanel/config.php';

$q = trim($_GET['q'] ?? '');
$results = [];

if ($q !== '') {
    $pattern = '/' . preg_quote($q, '/') . '/iu';

    $stmt = $pdo->query("
        SELECT
            d.id,
            d.name,
            d.description,
            b.name AS breed_name
        FROM dogs d
        LEFT JOIN breeds b ON b.id = d.breed_id
    ");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (
            preg_match($pattern, $row['name']) ||
            preg_match($pattern, $row['breed_name']) ||
            preg_match($pattern, $row['description'])
        ) {
            $results[] = $row;
        }
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Поиск — Dog Store</title>

  <!-- ТВОИ реальные стили -->
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/style-urbanpaw.css">
</head>

<body class="urbanpaw">
<?php include 'header.php'; ?>



<!-- ===== КОНТЕНТ ===== -->
<main class="container" style="max-width:720px; margin: 48px auto;">

  <h1>Поиск по сайту</h1>

  <form method="get" action="search.php" style="margin:24px 0;">
  <div style="display:flex; gap:12px; align-items:center;">
    <input
      type="text"
      name="q"
      value="<?= htmlspecialchars($q) ?>"
      placeholder="Введите запрос"
      class="form-control"
      style="flex:1;"
      required
    >
    <button class="btn btn-neon">Найти</button>
  </div>
</form>


  <?php if ($q === ''): ?>

    <p>Введите поисковый запрос.</p>

  <?php elseif (!$results): ?>

    <p>
      По запросу <b><?= htmlspecialchars($q) ?></b> ничего не найдено.
    </p>

  <?php else: ?>

    <p class="text-muted" style="margin:24px 0 12px;">
  Найдено: <?= count($results) ?>
</p>

<ul style="list-style:none; padding:0;">
  <?php foreach ($results as $dog): ?>
    <li style="margin-bottom:12px;">
      <a
        href="dog.php?id=<?= (int)$dog['id'] ?>&q=<?= urlencode($q) ?>"
        class="link-neon"
        style="font-size:18px;"
      >
        <?= htmlspecialchars($dog['name']) ?>
      </a>
      <span class="text-muted">
        — <?= htmlspecialchars($dog['breed_name']) ?>
      </span>
    </li>
  <?php endforeach; ?>
</ul>


  <?php endif; ?>

</main>
<?php include 'footer.php'; ?>

</body>
</html>
