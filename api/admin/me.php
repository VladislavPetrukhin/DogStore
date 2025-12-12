<?php
require_once __DIR__ . '/../../server/config.php';
if (!isset($_SESSION['user_id'])) json_out(['ok'=>false], 401);
json_out(['ok'=>true,'login'=>$_SESSION['login'] ?? '']);
