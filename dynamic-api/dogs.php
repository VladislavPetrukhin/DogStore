<?php
require_once __DIR__ . '/../dogpanel/config.php';
$stmt=$pdo->query("SELECT d.id,d.name,d.price,d.age,d.main_photo,b.name AS breed 
                   FROM dogs d LEFT JOIN breeds b ON d.breed_id=b.id 
                   ORDER BY d.created_at DESC");
echo json_encode($stmt->fetchAll());
?>