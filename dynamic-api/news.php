<?php
require_once __DIR__ . '/../dogpanel/config.php';
$stmt=$pdo->query("SELECT id,title,body,image,created_at FROM news ORDER BY created_at DESC");
echo json_encode($stmt->fetchAll());
