<?php
// dynamic-api/dogs.php
// API: возвращает список собак в JSON
// Поддерживает поиск ?q=...

require_once __DIR__ . '/../dogpanel/config.php';

header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');

$sql = "
SELECT 
    d.id,
    d.name,
    d.price,
    d.age,
    d.description,
    d.main_photo,
    b.name AS breed
FROM dogs d
LEFT JOIN breeds b ON d.breed_id = b.id
";

$params = [];

if ($q !== '') {
    $sql .= " WHERE d.name LIKE :q OR b.name LIKE :q ";
    $params[':q'] = '%' . $q . '%';
}

$sql .= " ORDER BY d.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$dogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($dogs, JSON_UNESCAPED_UNICODE);
