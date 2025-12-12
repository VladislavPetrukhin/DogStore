<?php
require_once __DIR__ . '/../../server/config.php';

$data = read_json();
$login = trim($data['login'] ?? '');
$pass  = (string)($data['password'] ?? '');

if ($login === '' || $pass === '') json_out(['ok'=>false,'error'=>'Введите логин и пароль'], 400);

$stmt = $pdo->prepare("SELECT id, login, password_hash FROM users WHERE login = ?");
$stmt->execute([$login]);
$u = $stmt->fetch();
if (!$u || !password_verify($pass, $u['password_hash'])) {
  json_out(['ok'=>false,'error'=>'Неверный логин или пароль'], 401);
}

$_SESSION['user_id'] = (int)$u['id'];
$_SESSION['login'] = $u['login'];

json_out(['ok'=>true,'login'=>$u['login']]);
