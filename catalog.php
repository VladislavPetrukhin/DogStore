<?php include 'head.php'; ?>
<?php include 'header.php'; ?>

<main class="py-5">
    <div class="container">
        <h1 class="mb-4">Каталог</h1>

        <div class="row g-4" id="dogs-container">
            <!-- Динамические карточки будут вставлены loadDogs.js -->
        </div>
    </div>
</main>

<!-- Подключение скрипта динамического каталога -->
<script src="assets/js/loadDogs.js"></script>

<?php include 'footer.php'; ?>
</body>
</html>
