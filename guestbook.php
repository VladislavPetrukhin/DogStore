<?php
require_once __DIR__.'/head.php';
require_once __DIR__.'/header.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Гостевая книга — DogStore</title>
  <link rel="stylesheet" href="assets/css/style-urbanpaw.css">
  
  <!-- jQuery & Slick Carousel (CDN) -->
  <link rel="stylesheet" href="assets/vendor/slick.css">
  <link rel="stylesheet" href="assets/vendor/slick-theme.css">
  <script src="assets/vendor/jquery.min.js"></script>
  <script src="assets/vendor/slick.min.js"></script>
  <!-- Project JS -->
  <script defer src="assets/js/main.js"></script>

</head>
<body>

<main class="container">
  <form id="guest-form" novalidate>
    <div class="form-row">
      <label>Имя <span class="req">*</span>
        <input type="text" name="name" required minlength="2" maxlength="40" placeholder="Имя">
      </label>
      <span class="error" data-for="name"></span>
    </div>

    <div class="form-row">
      <label>Email <span class="req">*</span>
        <input type="email" name="email" required placeholder="you@example.org">
      </label>
      <span class="error" data-for="email"></span>
    </div>

    <div class="form-row">
      <label>Оценка магазина
        <select name="rating">
          <option value="5">5 — отлично</option>
          <option value="4">4 — хорошо</option>
          <option value="3">3 — нормально</option>
          <option value="2">2 — плохо</option>
          <option value="1">1 — ужасно</option>
        </select>
      </label>
    </div>

    <div class="form-row">
      <label>Сообщение <span class="req">*</span>
        <textarea name="message" required minlength="10" maxlength="500" placeholder="Ваше мнение..."></textarea>
      </label>
      <span class="error" data-for="message"></span>
    </div>

    <div class="form-row inline">
      <label><input type="checkbox" name="agree" required> Соглашаюсь с обработкой персональных данных</label>
      <span class="error" data-for="agree"></span>
    </div>

    <div class="form-actions">
      <button type="submit">Отправить</button>
      <button type="reset">Очистить</button>
    </div>
  </form>

  <div class="tips">
    Подсказка: все поля с <span class="req">*</span> обязательны. Наведите курсор на поле — появится мини‑подсказка.
  </div>
</main>

</body>
</html>
<?php require_once __DIR__.'/footer.php'; ?>