<?php
require_once __DIR__ . '/server/config.php';


$id = (int)($_GET['id'] ?? 0);
$q  = trim($_GET['q'] ?? '');

$stmt = $pdo->prepare("
    SELECT 
        dogs.*,
        breeds.name AS breed_name
    FROM dogs
    LEFT JOIN breeds ON breeds.id = dogs.breed_id
    WHERE dogs.id = ?
");
$stmt->execute([$id]);
$dog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dog) {
    die('Собака не найдена');
}

function highlightText(string $text, string $q): string {
    $safe = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    if ($q === '') {
        return nl2br($safe);
    }

    $pattern = '/' . preg_quote($q, '/') . '/iu';

    return nl2br(
        preg_replace(
            $pattern,
            '<span class="search-highlight">$0</span>',
            $safe
        )
    );
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($dog['name']) ?> — DogStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h1><?= highlightText($dog['name'], $q) ?></h1>

<p>
    <b>Порода:</b>
    <?= highlightText($dog['breed_name'] ?? 'Не указана', $q) ?>
</p>

<?php if (!empty($dog['age'])): ?>
<p><b>Возраст:</b> <?= (int)$dog['age'] ?></p>
<?php endif; ?>

<?php if (!empty($dog['price'])): ?>
<p><b>Цена:</b> <?= htmlspecialchars($dog['price']) ?> ₽</p>
<?php endif; ?>

<p>
    <?= highlightText($dog['description'] ?? '', $q) ?>
</p>

</body>
</html>
