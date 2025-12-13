<?php
require_once __DIR__ . '/head.php';
require_once __DIR__ . '/header.php';
?>

<main class="py-5">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
      <div>
        <h1 class="display-6 m-0">Статистика магазина</h1>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-6">
        <section class="card p-4 h-100">
          <h2 class="h5 mb-3">Собаки по породам</h2>
          <div class="ratio ratio-4x3">
            <canvas
              id="chartBreeds"
              aria-label="Диаграмма распределения собак по породам"
              role="img">
            </canvas>
          </div>
          <div id="chartBreedsHint" class="small text-muted mt-3">
            В расчёт включаются только собаки с указанной породой и ценой.
          </div>
        </section>
      </div>

      <div class="col-lg-6">
        <section class="card p-4 h-100">
          <h2 class="h5 mb-3">Средняя цена по породам</h2>
          <div class="ratio ratio-4x3">
            <canvas
              id="chartAvgPrice"
              aria-label="График средней цены по породам"
              role="img">
            </canvas>
          </div>
          <div class="small text-muted mt-3">
            Средняя цена считается только по собакам с указанной ценой.
          </div>
        </section>
      </div>
    </div>


  </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script defer src="assets/js/stats.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const y = document.getElementById('year');
    if (y) y.textContent = new Date().getFullYear();
  });
</script>

</body>
</html>
