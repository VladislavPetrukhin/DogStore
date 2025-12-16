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
  <title>Уход — Dog Store</title>
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
    <h1 class="h2 mb-4">Уход и питание</h1>
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="accordion" id="careAccordion">
          <div class="accordion-item card">
            <h2 class="accordion-header" id="h1">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#c1" aria-expanded="true" aria-controls="c1">
                Питание
              </button>
            </h2>
            <div id="c1" class="accordion-collapse collapse show" aria-labelledby="h1" data-bs-parent="#careAccordion">
              <div class="accordion-body">
                <p>Рацион — по возрасту и активности. Свежая вода всегда доступна.</p>
                <ol><li>Щенок: 3–4 кормления/день</li><li>Взрослая собака: 2 кормления/день</li></ol>
              </div>
            </div>
          </div>
          <div class="accordion-item card">
            <h2 class="accordion-header" id="h2">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c2" aria-expanded="false" aria-controls="c2">
                Груминг
              </button>
            </h2>
            <div id="c2" class="accordion-collapse collapse" aria-labelledby="h2" data-bs-parent="#careAccordion">
              <div class="accordion-body">
                <ul><li>Вычёсывание 1–2 раза в неделю</li><li>Купание по мере необходимости</li><li>Стрижка когтей каждые 3–4 недели</li></ul>
              </div>
            </div>
          </div>
          <div class="accordion-item card">
            <h2 class="accordion-header" id="h3">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c3" aria-expanded="false" aria-controls="c3">
                Ветеринария
              </button>
            </h2>
            <div id="c3" class="accordion-collapse collapse" aria-labelledby="h3" data-bs-parent="#careAccordion">
              <div class="accordion-body">
                <p>График вакцинаций и обработок согласуйте с ветеринаром.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <aside class="card p-3">
          <h2 class="h6">Чек-лист для щенка</h2>
          <ul class="small"><li>Лежак и плед</li><li>Миски (вода/корм)</li><li>Шлейка и адресник</li><li>Игрушки для жевания</li></ul>
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
(function() {
  const here = location.pathname.split('/').pop();
  document.querySelectorAll('nav a').forEach(a => {
    if (a.getAttribute('href') === here) a.classList.add('active-link');
  });
})();
</script>
</body>
</html>
<?php require_once __DIR__.'/footer.php'; ?>o