<?php
require_once __DIR__.'/head.php';
require_once __DIR__.'/header.php';
?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Dog Store — магазин качественных собак. Галерея фотографий.">
  <title>Галерея — Dog Store</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="assets/css/style-urbanpaw.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


  <!-- Галерея -->
  <script defer src="assets/js/loadGallery.js"></script>
<style>
/* ОЧЕНЬ ЖЕСТКИЕ СТИЛИ — перекрывают любую тему */
.main-slider .slick-slide,
.dog-carousel.main-slider .slick-slide {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
}

.main-slider .slick-slide img,
.dog-carousel.main-slider .slick-slide img {
    max-height: 60vh !important; /* адаптивная высота */
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
    border-radius: 12px !important;
}

/* Миниатюры */
.thumb-slider .slick-slide img,
.dog-thumbs.thumb-slider .slick-slide img {
    height: 100px !important;
    width: auto !important;
    object-fit: contain !important;
    opacity: 0.6 !important;
    border-radius: 8px !important;
}

.thumb-slider .slick-current img,
.dog-thumbs.thumb-slider .slick-current img {
    opacity: 1 !important;
    border: 2px solid #0ff !important;
}
</style>


</head>

<body class="bg-dark-true text-body-urban">

<main class="py-5">
  <div class="container">
    <h1 class="big-title mb-4">Галерея</h1>

    <!-- Основной слайдер -->
    <div class="dog-carousel main-slider"></div>

    <!-- Превью-слайдер -->
    <div class="dog-thumbs thumb-slider mt-4"></div>
  </div>
</main>


<!-- Bootstrap JS (если нужен) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // актуальный год в футере
  document.addEventListener('DOMContentLoaded', () => {
    const y = document.getElementById('year');
    if (y) y.textContent = new Date().getFullYear();
  });
</script>

</body>
</html>
<?php require_once __DIR__.'/footer.php'; ?>