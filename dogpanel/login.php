<?php
require_once __DIR__ . '/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Введите логин и пароль.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && $user['password'] === $password) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = 'Неверный логин или пароль.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в DogPanel</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-page">
    <div class="login-card">
        <div class="login-title">
            <span class="logo-icon">🐾</span>
            <span>DogPanel</span>
        </div>
        <div class="login-sub">Вход в панель управления DogStore</div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo h($error); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-row">
                <label for="username">Логин</label>
                <input type="text" id="username" name="username" value="<?php echo h($_POST['username'] ?? 'admin'); ?>">
            </div>
            <div class="form-row">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" value="<?php echo h($_POST['password'] ?? 'ilovedogs'); ?>">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn" style="width: 100%;">Войти</button>
            </div>
        </form>
    </div>
</body>
</html>
