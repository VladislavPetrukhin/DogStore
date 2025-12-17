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

<?php include 'head.php'; ?>
<?php include 'header.php'; ?>

<main>
<section id="hero" class="py-5">
  <div class="container">
    <div class="row align-items-start">

      <!-- ЛЕВАЯ КОЛОНКА: текст + кнопки + поиск + карточка -->
      <div class="col-lg-7 d-flex flex-column">

        <h1 class="hero-title">
          Dog Store — магазин качественных собак
        </h1>

        <p class="lead mt-3">
          Подберите породу под ваш образ жизни и найдите собаку мечты.
        </p>

        <div class="d-flex gap-3 mt-4">
          <a href="catalog.php" class="btn btn-neon btn-lg">
            Посмотреть собак
          </a>
          <a href="breeds.php" class="btn btn-outline-neon btn-lg">
            Подобрать породу
          </a>
        </div>

        <form action="search.php" method="get" class="hero-search mt-4">
          <div class="hero-search-inner">
            <input
              type="text"
              name="q"
              placeholder="Поиск по сайту"
              aria-label="Поиск по сайту"
              required
            >
            <button type="submit" class="hero-search-btn">Найти</button>
          </div>
        </form>

        <aside class="p-4 card mt-4">
          <h2 class="h4">Что такое Urban Paw?</h2>
          <p>
            Стиль собаки. Современный подход к изучению и содержанию питомцев.
          </p>
        </aside>

      </div>

      <!-- ПРАВАЯ КОЛОНКА-->
      <div class="col-lg-5 d-none d-lg-block">
        <!-- можно оставить пустой -->
      </div>

    </div>
  </div>
</section>


<!-- Popular breeds -->
<section class="py-5">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-4">
      <h2 class="h3 mb-0">Популярные породы</h2>
      <a href="breeds.php" class="btn btn-sm btn-outline-light">Все породы</a>
    </div>

    <div class="row g-4">

      <!-- Самоед -->
      <div class="col-12 col-sm-6 col-lg-3">
        <article class="card shadow-neon h-100 overflow-hidden breed-card">
          <img
            src="https://cdn.profile.ru/wp-content/uploads/2021/06/Samoedskaya-sobaka.jpg"
            class="card-img-top breed-img"
            alt="Самоед"
          >
          <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h3 class="h5 mb-0 breed-title">Самоед</h3>
              <span class="badge bg-primary">топ</span>
            </div>

            <p class="text-muted small mb-3 breed-desc">
              Пушистик-улыбака: дружелюбный, активный, семейный.
            </p>

            <div class="d-grid gap-2 mt-auto">
              <a href="breed.php?id=1" class="btn btn-neon btn-sm">Подробнее</a>
              <a href="catalog.php?q=%D0%A1%D0%B0%D0%BC%D0%BE%D0%B5%D0%B4" class="btn btn-outline-light btn-sm">Смотреть собак</a>
            </div>
          </div>
        </article>
      </div>

      <!-- Немецкая овчарка -->
      <div class="col-12 col-sm-6 col-lg-3">
        <article class="card shadow-neon h-100 overflow-hidden breed-card">
          <img
            src="https://i.pinimg.com/736x/97/a2/3f/97a23f867c347604fb542e98c624e2b8.jpg"
            class="card-img-top breed-img"
            alt="Немецкая овчарка"
          >
          <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h3 class="h5 mb-0 breed-title">Немецкая овчарка</h3>
              <span class="badge bg-primary">умница</span>
            </div>

            <p class="text-muted small mb-3 breed-desc">
              Служебная легенда: интеллект, дисциплина, верность.
            </p>

            <div class="d-grid gap-2 mt-auto">
              <a href="breed.php?id=2" class="btn btn-neon btn-sm">Подробнее</a>
              <a href="catalog.php?q=%D0%9D%D0%B5%D0%BC%D0%B5%D1%86%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B2%D1%87%D0%B0%D1%80%D0%BA%D0%B0" class="btn btn-outline-light btn-sm">Смотреть собак</a>
            </div>
          </div>
        </article>
      </div>

      <!-- Лабрадор -->
      <div class="col-12 col-sm-6 col-lg-3">
        <article class="card shadow-neon h-100 overflow-hidden breed-card">
          <img
            src="https://i.pinimg.com/736x/42/62/62/42626220ecd2c750b4eef7214d604258.jpg"
            class="card-img-top breed-img"
            alt="Лабрадор"
          >
          <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h3 class="h5 mb-0 breed-title">Лабрадор</h3>
              <span class="badge bg-primary">друг</span>
            </div>

            <p class="text-muted small mb-3 breed-desc">
              Идеальный компаньон: добрый, контактный, семейный.
            </p>

            <div class="d-grid gap-2 mt-auto">
              <a href="breed.php?id=3" class="btn btn-neon btn-sm">Подробнее</a>
              <a href="catalog.php?q=%D0%9B%D0%B0%D0%B1%D1%80%D0%B0%D0%B4%D0%BE%D1%80%20%D1%80%D0%B5%D1%82%D1%80%D0%B8%D0%B2%D0%B5%D1%80" class="btn btn-outline-light btn-sm">Смотреть собак</a>
            </div>
          </div>
        </article>
      </div>

      <!-- Корги -->
      <div class="col-12 col-sm-6 col-lg-3">
        <article class="card shadow-neon h-100 overflow-hidden breed-card">
          <img
            src="https://avatars.mds.yandex.net/get-ydo/9710801/2a00000189e8f21a78a9d2ee0c0e11e8d0ce/diploma"
            class="card-img-top breed-img"
            alt="Корги"
          >
          <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h3 class="h5 mb-0 breed-title">Корги</h3>
              <span class="badge bg-primary">вайб</span>
            </div>

            <p class="text-muted small mb-3 breed-desc">
              Компактный пастух: умный, бодрый, харизматичный.
            </p>

            <div class="d-grid gap-2 mt-auto">
              <a href="breed.php?id=7" class="btn btn-neon btn-sm">Подробнее</a>
              <a href="catalog.php?q=%D0%9A%D0%BE%D1%80%D0%B3%D0%B8" class="btn btn-outline-light btn-sm">Смотреть собак</a>
            </div>
          </div>
        </article>
      </div>

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
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('particles-js');
  if (!el || typeof particlesJS !== 'function') return;

  particlesJS('particles-js', {
    particles: {
      number: { value: 100, density: { enable: true, value_area: 900 } },
      color: { value: "#00f5ff" },
      shape: { type: "circle" },
      opacity: { value: 0.35, random: true },
      size: { value: 2.5, random: true },
      line_linked: { enable: true, distance: 140, opacity: 0.18, width: 1 },
      move: { enable: true, speed: 1.2, out_mode: "out" }
    },
    interactivity: {
      detect_on: "window",
      events: {
        onhover: { enable: true, mode: "grab" },
        onclick: { enable: true, mode: "push" },
        resize: true
      },
      modes: {
        grab: { distance: 160, line_linked: { opacity: 0.35 } },
        push: { particles_nb: 2 }
      }
    },
    retina_detect: true
  });
});
</script>

</body>
</html>
