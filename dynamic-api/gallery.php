<?php
require_once __DIR__ . '/../dogpanel/config.php';
$stmt=$pdo->query("SELECT filename FROM gallery_photos ORDER BY uploaded_at DESC");
$out=[];
foreach($stmt->fetchAll() as $p){
 $out[]=["photo"=>$p['filename']];
}
echo json_encode($out);
?>