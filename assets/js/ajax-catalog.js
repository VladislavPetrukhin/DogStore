document.addEventListener('DOMContentLoaded', () => {
  const listEl = document.getElementById('dogsList');
  const searchEl = document.getElementById('dogsSearch');
  const modalEl = document.getElementById('dogModal');
  const modal = modalEl ? new bootstrap.Modal(modalEl) : null;

  async function loadList() {
    const q = (searchEl?.value || '').trim();
    const url = q ? `/api/dogs.php?q=${encodeURIComponent(q)}` : '/api/dogs.php';
    const r = await fetch(url);
    const dogs = await r.json();

    if (!Array.isArray(dogs)) {
      listEl.innerHTML = `<div class="text-danger">Ошибка загрузки списка</div>`;
      return;
    }

    listEl.innerHTML = dogs.map(d => {
      const breed = d.breed || '—';
      const price = d.price ? `${d.price} ₽` : '—';
      return `
        <div class="col-12 col-sm-6 col-lg-4">
          <button class="card p-3 text-start w-100 h-100 dog-card" data-id="${d.id}" style="background:rgba(255,255,255,.03); border:1px solid rgba(0,255,255,.15);">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="h5 m-0">${escapeHtml(d.name)}</div>
                <div class="small text-muted">${escapeHtml(breed)}</div>
              </div>
              <span class="badge bg-info text-dark">${escapeHtml(price)}</span>
            </div>
            <div class="small mt-2 text-muted">Нажми — подробности (AJAX)</div>
          </button>
        </div>`;
    }).join('');

    listEl.querySelectorAll('.dog-card').forEach(btn => {
      btn.addEventListener('click', () => openDog(btn.dataset.id));
    });
  }

  async function openDog(id) {
    const body = document.getElementById('dogModalBody');
    const title = document.getElementById('dogModalTitle');
    body.innerHTML = '<div class="text-muted">Загрузка…</div>';
    title.textContent = 'Загрузка…';
    modal.show();

    const r = await fetch(`/api/dog.php?id=${encodeURIComponent(id)}`);
    const dog = await r.json();

    if (!dog || dog.error) {
      title.textContent = 'Ошибка';
      body.innerHTML = `<div class="text-danger">${escapeHtml(dog?.error || 'Не удалось загрузить')}</div>`;
      return;
    }

    title.textContent = dog.name;

    body.innerHTML = `
      <div class="row g-3">
        <div class="col-md-5">
          <div class="ratio ratio-4x3 rounded overflow-hidden" style="background:rgba(255,255,255,.04);">
            <img src="${dog.main_photo ? `/uploads/dogs/${encodeURIComponent(dog.main_photo)}` : 'assets/img/no-photo.png'}"
                 alt="" style="width:100%;height:100%;object-fit:cover;">
          </div>
        </div>
        <div class="col-md-7">
          <div class="mb-2"><span class="badge bg-secondary">${escapeHtml(dog.breed || '—')}</span></div>
          <div class="mb-2"><strong>Цена:</strong> ${dog.price ? escapeHtml(String(dog.price)) + ' ₽' : '—'}</div>
          <div class="mb-2"><strong>Возраст:</strong> ${dog.age_months ? escapeHtml(String(dog.age_months)) + ' мес.' : '—'}</div>
          <div class="mb-2"><strong>Пол:</strong> ${escapeHtml(dog.sex || '—')}</div>
          <div class="mb-3"><strong>Окрас:</strong> ${escapeHtml(dog.color || '—')}</div>
          <div style="white-space:pre-wrap;">${escapeHtml(dog.description || 'Описание отсутствует')}</div>
        </div>
      </div>
    `;
  }

  function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  }

  if (searchEl) searchEl.addEventListener('input', debounce(loadList, 250));
  loadList();
});

function debounce(fn, ms) {
  let t;
  return (...args) => {
    clearTimeout(t);
    t = setTimeout(() => fn(...args), ms);
  };
}
