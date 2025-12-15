<?php
require_once __DIR__.'/head.php';
require_once __DIR__.'/header.php';
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Dog Store — магазин качественных собак. Молодёжный неоновый стиль Urban Paw.">
  <title>Музей — Dog Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style-urbanpaw.css">

    <!-- jQuery & Slick Carousel (CDN) -->
    <link rel="stylesheet" href="assets/vendor/slick.css">
    <link rel="stylesheet" href="assets/vendor/slick-theme.css">
    <script src="assets/vendor/jquery.min.js"></script>
    <script src="assets/vendor/slick.min.js"></script>
    <!-- Project JS -->
    <script defer src="assets/js/main.js"></script>
</head>
<body class="bg-dark-true text-body-urban">
<main>

<section class="py-5">
  <div class="container">
    <h1 class="h2 mb-4">История и «музей»</h1>
    <div class="row g-4">
      <div class="col-md-8">
        <article class="card p-3">
          <section class="mb-4">
            <h2 class="h5">Таймлайн одомашнивания</h2>
            <p class="text-muted">От партнёрства в охоте до городской семьи.</p>
            <div class="row row-cols-1 row-cols-md-2 g-3">
              <div class="col"><div class="p-3 card">Древность: совместная охота</div></div>
              <div class="col"><div class="p-3 card">Средневековье: сторожевые</div></div>
              <div class="col"><div class="p-3 card">XIX век: стандарты пород</div></div>
              <div class="col"><div class="p-3 card">XX век: служебные и компаньоны</div></div>
            </div>
          </section>
          <section class="mb-0">
            <h2 class="h5">Экспонаты</h2>
            <div class="row g-3">
              <div class="col-sm-6 col-lg-4">
                <figure class="figure">
                  <img class="figure-img img-fluid rounded card-img-top" src="https://commons.wikimedia.org/wiki/Special:FilePath/Golden%20Retriever%20standing%20Tucker.jpg" alt="Экспонат">
                  <figcaption class="figure-caption text-muted">Редкая порода: заметки заводчиков.</figcaption>
                </figure>
              </div>
              <div class="col-sm-6 col-lg-4">
                <figure class="figure">
                  <img class="figure-img img-fluid rounded card-img-top" src="https://commons.wikimedia.org/wiki/Special:FilePath/White%20Samoyed%20dog1.jpg" alt="Артефакт">
                  <figcaption class="figure-caption text-muted">Артефакт: старинный ошейник.</figcaption>
                </figure>
              </div>
            </div>
          </section>
        </article>
      </div>
      <div class="col-md-4">
        <aside class="card p-3">
          <h2 class="h6">Экспонат дня</h2>
          <p><strong>Адресник XIX века</strong> — первый «паспорт» питомца в городе.</p>
        </aside>
      </div>
    </div>
  </div>
</section>
</main>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const y = document.getElementById('year');
    if (y) y.textContent = new Date().getFullYear();
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Inline script (SCRIPT container) required by the lab:
(function() {
  // Show active page in nav
  const here = location.pathname.split('/').pop();
  document.querySelectorAll('nav a').forEach(a => {
    if (a.getAttribute('href') === here) a.classList.add('active-link');
  });
})();
</script>
</body>
</html>
<?php require_once __DIR__.'/footer.php'; ?>