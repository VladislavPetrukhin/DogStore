<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>DogPanel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="logo">
            <span class="logo-icon">🐾</span>
            <span class="logo-text">DogPanel</span>
        </div>
        <?php if (!empty($_SESSION['user_id'])): ?>
        <nav class="nav">
            <a href="dashboard.php" class="nav-item">Панель</a>
            <a href="dogs.php" class="nav-item">Собаки</a>
	<a href="gallery.php" class="nav-item">Галерея</a>
            <a href="news.php" class="nav-item">Новости</a>
            <a href="reviews.php" class="nav-item">Отзывы</a>
            <a href="logout.php" class="nav-item nav-item--danger">Выйти</a>
        </nav>
        <?php endif; ?>
    </aside>
    <main class="main">
        <header class="topbar">
            <div class="topbar-title">Панель управления DogStore</div>
        </header>
        <section class="content">
