async function api(path, body = null) {
  const options = body
    ? {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
      }
    : {};

  const response = await fetch(path, options);
  const data = await response.json().catch(() => ({}));

  if (!response.ok) {
    throw new Error(data.error || `HTTP ${response.status}`);
  }

  return data;
}

document.addEventListener('DOMContentLoaded', () => {
  const dogsBody = document.getElementById('dogsBody');
  const modalEl  = document.getElementById('editModal');
  const addBtn   = document.getElementById('addDogBtn');
  const addErr   = document.getElementById('addErr');
  const newName  = document.getElementById('newName');
  const newPrice = document.getElementById('newPrice');
  const newDesc  = document.getElementById('newDesc');

  if (!dogsBody || !modalEl || typeof bootstrap === 'undefined') {
    console.warn('AJAX dashboard: элементы не найдены');
    return;
  }

  const modal = new bootstrap.Modal(modalEl);

  const editId    = document.getElementById('editId');
  const editName  = document.getElementById('editName');
  const editPrice = document.getElementById('editPrice');
  const editDesc  = document.getElementById('editDesc');
  const editErr   = document.getElementById('editErr');
  const saveBtn   = document.getElementById('saveBtn');

  function showError(msg) {
    editErr.textContent = msg;
    editErr.style.display = 'block';
  }

  function hideError() {
    editErr.textContent = '';
    editErr.style.display = 'none';
  }

  // Делегирование кликов (EDIT / DELETE)
  dogsBody.addEventListener('click', async (e) => {
    const btn = e.target.closest('button[data-act]');
    if (!btn) return;

    const id  = Number(btn.dataset.id);
    const act = btn.dataset.act;

    try {
      // УДАЛЕНИЕ
      if (act === 'del') {
        if (!confirm('Удалить собаку?')) return;

        await api('../api/admin/dog_delete.php', { id });
        btn.closest('tr')?.remove();
      }

      // РЕДАКТИРОВАНИЕ
      if (act === 'edit') {
        const dog = await fetch(`../api/dog.php?id=${id}`).then(r => r.json());

        editId.value    = dog.id;
        editName.value  = dog.name || '';
        editPrice.value = dog.price || 0;
        editDesc.value  = dog.description || '';

        hideError();
        modal.show();
      }

    } catch (err) {
      alert(err.message);
    }
  });

  // СОХРАНЕНИЕ ИЗ МОДАЛКИ
  saveBtn.addEventListener('click', async () => {
    hideError();

    try {
      const payload = {
        id: Number(editId.value),
        name: editName.value.trim(),
        price: Number(editPrice.value),
        description: editDesc.value.trim()
      };

      await api('../api/admin/dog_update.php', payload);

      // Обновляем строку таблицы без перезагрузки
      const row = dogsBody.querySelector(`button[data-id="${payload.id}"]`)?.closest('tr');
      if (row) {
        row.children[1].textContent = payload.name;
        // В таблице на dashboard цена не выводится — не трогаем столбец "Создано"
      }

      modal.hide();
    } catch (err) {
      showError(err.message);
    }
  });

  // ДОБАВЛЕНИЕ СОБАКИ (AJAX)
  if (addBtn) {
    addBtn.addEventListener('click', async (e) => {
      e.preventDefault();
      addErr.style.display = 'none';

      try {
        const dog = await api('../api/admin/dog_create.php', {
          name: newName.value.trim(),
          price: Number(newPrice.value),
          description: newDesc.value.trim()
        });

        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${dog.id}</td>
          <td>${dog.name}</td>
          <td>—</td>
          <td>только что</td>
          <td>
            <button class="btn btn-sm btn-outline-info me-2" data-act="edit" data-id="${dog.id}">
              Редактировать
            </button>
            <button class="btn btn-sm btn-outline-danger" data-act="del" data-id="${dog.id}">
              Удалить
            </button>
          </td>
        `;

        dogsBody.prepend(tr);

        newName.value = '';
        newPrice.value = '';
        newDesc.value = '';

      } catch (err) {
        addErr.textContent = err.message;
        addErr.style.display = 'block';
      }
    });
  }
});
