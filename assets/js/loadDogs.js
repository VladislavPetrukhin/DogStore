// assets/js/loadDogs.js
// AJAX-каталог + поиск без перезагрузки страницы

document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('dogs-container');
  const searchInput = document.getElementById('dog-search');

  if (!container) return;

  // === Загрузка собак (все или по поиску) ===
  function loadDogs(query = '') {
    const url = query
      ? `/dynamic-api/dogs.php?q=${encodeURIComponent(query)}`
      : `/dynamic-api/dogs.php`;

    fetch(url)
      .then(res => res.json())
      .then(dogs => {
        container.innerHTML = '';

        if (!dogs.length) {
          container.innerHTML =
            '<p class="text-muted">Ничего не найдено</p>';
          return;
        }

        dogs.forEach(d => {
          const img = d.main_photo
            ? `/dogpanel/uploads/dogs/${d.main_photo}`
            : `/assets/img/no-photo.png`;

          const col = document.createElement('div');
          col.className = 'col-12 col-sm-6 col-lg-4';

          col.innerHTML = `
            <article class="card p-3 h-100 dog-card" data-id="${d.id}">
              <img src="${img}"
                   class="card-img-top mb-3"
                   style="height:260px;object-fit:cover;">
              
              <h3 class="h5 mb-1">${d.name}</h3>

              <span class="badge bg-primary mb-2">
                ${d.breed || 'Порода не указана'}
              </span>

              <p class="mb-1">
                <strong>Цена:</strong> ${d.price ?? '—'}
              </p>

              <p class="text-muted small">
                ${d.description ? d.description.substring(0, 80) + '…' : ''}
              </p>
            </article>
          `;

          container.appendChild(col);
        });
      })
      .catch(err => {
        console.error('Ошибка AJAX:', err);
        container.innerHTML =
          '<p class="text-danger">Ошибка загрузки данных</p>';
      });
  }

  // 🔥 ВАЖНО: загружаем ВСЕХ собак при открытии страницы
  loadDogs();

  // 🔎 Поиск (AJAX)
  if (searchInput) {
    let timer;
    searchInput.addEventListener('input', () => {
      clearTimeout(timer);
      timer = setTimeout(() => {
        loadDogs(searchInput.value.trim());
      }, 300);
    });
  }
});
