<?php include 'head.php'; ?>
<?php include 'header.php'; ?>

<main class="py-5">
    <div class="container">
        <h1 class="mb-4">Каталог</h1>
<div class="d-flex flex-column flex-md-row gap-3 align-items-md-center mb-4">
  <input id="dog-search" class="form-control">
  <div class="text-muted small">Клик по карточке → подробности в модалке (AJAX, JSON)</div>
</div>

        <div class="row g-4" id="dogs-container">
            <!-- Динамические карточки будут вставлены loadDogs.js -->
        </div>
    </div>
</main>
<div class="modal fade" id="dogModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-secondary">
        <h5 class="modal-title" id="dogModalTitle">Собака</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="dogModalBody"></div>
    </div>
  </div>
</div>

<!-- Подключение скрипта динамического каталога -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/loadDogs.js"></script>


<?php include 'footer.php'; ?>
</body>
</html>
