<?php
require_once __DIR__.'/head.php';
require_once __DIR__.'/header.php';
?>
<!doctype html>
<html lang="ru">
<body class="bg-dark-true text-body-urban">
<main>

<section class="py-5" id="contacts">
  <div class="container">
    <h1 class="h2 mb-4">О нас и контакты</h1>
    <div class="row g-4">
      <div class="col-lg-6">
        <article class="card p-3">
          <h2 class="h5">Миссия</h2>
          <p>Мы совмещаем молодёжный стиль и ответственное отношение к собакам. Подбираем породу под образ жизни, помогаем с уходом и социализацией.</p>
          <h2 class="h5">График работы</h2>
          <table class="table table-sm">
            <thead><tr><th scope="col">День</th><th scope="col">Часы</th></tr></thead>
            <tbody><tr><td>Пн–Пт</td><td>10:00–19:00</td></tr><tr><td>Сб</td><td>11:00–16:00</td></tr><tr><td>Вс</td><td>Выходной</td></tr></tbody>
          </table>
        </article>
      </div>
      <div class="col-lg-6">
        <form class="card p-3">
          <div class="mb-3"><label for="name" class="form-label">Имя</label><input id="name" type="text" class="form-control" placeholder="Как к вам обращаться?" required></div>
          <div class="mb-3"><label for="email" class="form-label">Email</label><input id="email" type="email" class="form-control" placeholder="name@example.com" required></div>
          <div class="mb-3"><label for="msg" class="form-label">Сообщение</label><textarea id="msg" class="form-control" rows="4" placeholder="Коротко о вашем вопросе…"></textarea></div>
          <button class="btn btn-neon" type="submit">Отправить</button>
        </form>
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
<?php require_once __DIR__.'/footer.php'; ?>