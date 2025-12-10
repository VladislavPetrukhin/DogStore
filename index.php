<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Dog Store — магазин качественных собак. Молодёжный неоновый стиль Urban Paw.">
  <title>Главная — Dog Store</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="assets/css/style-urbanpaw.css">

  <!-- jQuery & Slick -->
  <link rel="stylesheet" href="assets/vendor/slick.css">
  <link rel="stylesheet" href="assets/vendor/slick-theme.css">
  <script src="assets/vendor/jquery.min.js"></script>
  <script src="assets/vendor/slick.min.js"></script>

  <!-- Project JS -->
  <script defer src="assets/js/main.js"></script>
</head>

<body class="bg-dark-true text-body-urban">

<?php include 'header.php'; ?>

<main>
  <!-- Hero block -->
  <section id="hero" class="py-5">
    <div class="container">
      <div class="row align-items-center">

        <div class="col-lg-7">
          <h1 class="hero-title">Dog Store — магазин качественных собак</h1>
          <p class="lead mt-3">Подберите породу под ваш образ жизни и найдите собаку мечты.</p>

          <div class="d-flex gap-3 mt-4">
            <a href="catalog.php" class="btn btn-neon btn-lg">Посмотреть собак</a>
            <a href="breeds.php" class="btn btn-outline-neon btn-lg">Подобрать породу</a>
          </div>
        </div>

        <div class="col-lg-5 mt-4 mt-lg-0">
          <aside class="p-4 card">
            <h2 class="h4">Что такое Urban Paw?</h2>
            <p>Стиль собаки. Современный подход к изучению и содержанию питомцев.</p>
          </aside>
        </div>

      </div>
    </div>
  </section>

  <!-- Popular breeds -->
  <section class="py-5">
    <div class="container">
      <h2 class="h3 mb-4">Популярные породы</h2>
      <div class="row g-4">

        <!-- Карточки — оставлены без изменений -->

        <!-- ... -->
        
      </div>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const y = document.getElementById('year');
    if (y) y.textContent = new Date().getFullYear();
  });
</script>

</body>
</html>
