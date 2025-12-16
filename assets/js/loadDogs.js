document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('dogs-container');
  const searchInput = document.getElementById('dog-search');

  if (!container) return;

  const modalEl = document.getElementById('dogModal');
  const modalTitle = document.getElementById('dogModalTitle');
  const modalBody = document.getElementById('dogModalBody');
  const modal = (modalEl && window.bootstrap) ? new bootstrap.Modal(modalEl) : null;

  function loadDogs(query = '') {
    const url = query
      ? `/dynamic-api/dogs.php?q=${encodeURIComponent(query)}`
      : `/dynamic-api/dogs.php`;

    fetch(url)
      .then(res => res.json())
      .then(dogs => {
        container.innerHTML = '';

        if (!Array.isArray(dogs) || !dogs.length) {
          container.innerHTML = '<p class="text-muted">Ничего не найдено</p>';
          return;
        }

        dogs.forEach(d => {
          const img = d.main_photo
            ? `/dogpanel/uploads/dogs/${d.main_photo}`
            : `/assets/img/no-photo.png`;

          const col = document.createElement('div');
          col.className = 'col-12 col-sm-6 col-lg-4';

          col.innerHTML = `
            <article class="card p-3 h-100 dog-card" data-id="${d.id}" role="button" tabindex="0">
              <img src="${img}"
                   class="card-img-top mb-3"
                   style="height:260px;object-fit:cover;">
              
              <h3 class="h5 mb-1">${escapeHtml(d.name ?? '—')}</h3>

              <span class="badge bg-primary mb-2">
                ${escapeHtml(d.breed || 'Порода не указана')}
              </span>

              <p class="mb-1">
                <strong>Цена:</strong> ${d.price ?? '—'}
              </p>

              <p class="text-muted small">
                ${d.description ? escapeHtml(String(d.description).substring(0, 80)) + '…' : ''}
              </p>
            </article>
          `;

          container.appendChild(col);
        });
      })
      .catch(err => {
        console.error('Ошибка AJAX:', err);
        container.innerHTML = '<p class="text-danger">Ошибка загрузки данных</p>';
      });
  }

  function loadDogDetails(id) {
    if (!modal || !modalTitle || !modalBody) return;

    modalTitle.textContent = 'Загрузка...';
    modalBody.innerHTML = '<div class="text-muted">Подгружаем данные…</div>';
    modal.show();

    fetch(`/dynamic-api/dog.php?id=${encodeURIComponent(id)}`)
      .then(res => res.json().then(data => ({ ok: res.ok, data })))
      .then(({ ok, data }) => {
        if (!ok) throw new Error(data?.error || 'Ошибка загрузки');

        const img = data.main_photo
          ? `/dogpanel/uploads/dogs/${data.main_photo}`
          : `/assets/img/no-photo.png`;

        modalTitle.textContent = data.name || 'Собака';

        const age = (data.age !== null && data.age !== undefined && data.age !== '')
          ? `<div class="mb-2"><strong>Возраст:</strong> ${escapeHtml(String(data.age))}</div>`
          : '';

        const price = (data.price !== null && data.price !== undefined && data.price !== '')
          ? `<div class="mb-2"><strong>Цена:</strong> ${escapeHtml(String(data.price))}</div>`
          : '';

        const breed = data.breed
          ? `<span class="badge bg-primary">${escapeHtml(String(data.breed))}</span>`
          : `<span class="badge bg-secondary">Порода не указана</span>`;

        const desc = data.description
          ? `<div class="mt-3"><strong>Описание</strong><div class="text-muted mt-1">${nl2br(escapeHtml(String(data.description)))}</div></div>`
          : `<div class="mt-3 text-muted">Описание не добавлено.</div>`;

        modalBody.innerHTML = `
          <div class="row g-4">
            <div class="col-lg-5">
              <img src="${img}" class="img-fluid rounded-3" alt="">
            </div>
            <div class="col-lg-7">
              <div class="mb-3">${breed}</div>
              ${age}
              ${price}
              ${desc}
            </div>
          </div>
        `;
      })
      .catch(err => {
        console.error(err);
        modalTitle.textContent = 'Ошибка';
        modalBody.innerHTML = `<div class="text-danger">${escapeHtml(err.message || 'Не удалось загрузить данные')}</div>`;
      });
  }

  container.addEventListener('click', (e) => {
    const card = e.target.closest('.dog-card');
    if (!card) return;
    const id = card.getAttribute('data-id');
    if (id) loadDogDetails(id);
  });

  container.addEventListener('keydown', (e) => {
    if (e.key !== 'Enter') return;
    const card = e.target.closest('.dog-card');
    if (!card) return;
    const id = card.getAttribute('data-id');
    if (id) loadDogDetails(id);
  });

  const urlQ = new URLSearchParams(location.search).get('q');
  if (searchInput && urlQ) {
    searchInput.value = urlQ;
    loadDogs(urlQ);
  } else {
    loadDogs();
  }

  if (searchInput) {
    let timer;
    searchInput.addEventListener('input', () => {
      clearTimeout(timer);
      timer = setTimeout(() => {
        loadDogs(searchInput.value.trim());
      }, 300);
    });
  }

  function escapeHtml(s) {
    return String(s)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }
  function nl2br(s) {
    return String(s).replace(/\n/g, '<br>');
  }
});
