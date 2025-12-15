<?php
require_once __DIR__.'/head.php';
require_once __DIR__.'/header.php';
?>
<!doctype html>
<html lang="ru">
<body class="bg-dark-true text-body-urban">
<main>

<section class="py-5">
  <div class="container">
    <h1 class="h2 mb-4">Энциклопедия пород</h1>
    <aside class="mb-3">
      <p class="small text-muted">Группы <abbr title="Fédération Cynologique Internationale">FCI</abbr> (статично): 
        <a href="#" class="link-neon">Группа 1</a> · <a href="#" class="link-neon">Группа 2</a> · <a href="#" class="link-neon">Группа 9</a>
      </p>
    </aside>
    <div class="row g-4">
      
    <div class="col-12 col-sm-6 col-lg-4">
      <article class="card shadow-neon h-100">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/White%20Samoyed%20dog1.jpg" class="card-img-top img-fluid" alt="Порода Самоед">
        <div class="card-body">
          <h3 class="card-title h5">Самоед</h3>
          <p class="card-text">Северный оптимист — улыбчивый и активный.</p>
          <a href="breed-samoyed.html" class="btn btn-sm btn-neon">Подробнее</a>
        </div>
      </article>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
      <article class="card shadow-neon h-100">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/German%20Shepherd%20-%20DSC%200346%20(10096362833).jpg" class="card-img-top img-fluid" alt="Порода Немецкая овчарка">
        <div class="card-body">
          <h3 class="card-title h5">Немецкая овчарка</h3>
          <p class="card-text">Умная, выносливая, обучаемая.</p>
          <a href="breed-gsd.html" class="btn btn-sm btn-neon">Подробнее</a>
        </div>
      </article>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
      <article class="card shadow-neon h-100">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Female%20Black%20Labrador%20Retriever.jpg" class="card-img-top img-fluid" alt="Порода Лабрадор-ретривер">
        <div class="card-body">
          <h3 class="card-title h5">Лабрадор-ретривер</h3>
          <p class="card-text">Спокойный и дружелюбный компаньон.</p>
          <a href="breed-labrador.html" class="btn btn-sm btn-neon">Подробнее</a>
        </div>
      </article>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
      <article class="card shadow-neon h-100">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Golden%20Retriever%20standing%20Tucker.jpg" class="card-img-top img-fluid" alt="Порода Золотистый ретривер">
        <div class="card-body">
          <h3 class="card-title h5">Золотистый ретривер</h3>
          <p class="card-text">Ласковый, контактный и терпеливый.</p>
          <a href="breed-golden.html" class="btn btn-sm btn-neon">Подробнее</a>
        </div>
      </article>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
      <article class="card shadow-neon h-100">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Siberian-husky-1291343_1920.jpg" class="card-img-top img-fluid" alt="Порода Сибирский хаски">
        <div class="card-body">
          <h3 class="card-title h5">Сибирский хаски</h3>
          <p class="card-text">Любит бег, независим в дрессировке.</p>
          <a href="breed-husky.html" class="btn btn-sm btn-neon">Подробнее</a>
        </div>
      </article>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
      <article class="card shadow-neon h-100">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Great%20Dane%20puppy%20blue.jpg" class="card-img-top img-fluid" alt="Порода Немецкий дог">
        <div class="card-body">
          <h3 class="card-title h5">Немецкий дог</h3>
          <p class="card-text">Нежный гигант — друг всей семьи.</p>
          <a href="breed-greatdane.html" class="btn btn-sm btn-neon">Подробнее</a>
        </div>
      </article>
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