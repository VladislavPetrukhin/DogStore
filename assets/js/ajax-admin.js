async function api(path, body = null) {
  const opt = body
    ? { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(body) }
    : {};
  const r = await fetch(path, opt);
  const data = await r.json().catch(() => ({}));
  if (!r.ok) throw Object.assign(new Error(data.error || ('HTTP ' + r.status)), { status: r.status, data });
  return data;
}

document.addEventListener('DOMContentLoaded', () => {
  const dogsBody = document.getElementById('dogsBody');
  const editModalEl = document.getElementById('editModal');

  // Если мы не на странице с таблицей собак — просто выходим, без ошибок
  if (!dogsBody || !editModalEl) return;

  const editModal = new bootstrap.Modal(editModalEl);

  const editId   = document.getElementById('editId');
  const editName = document.getElementById('editName');
  const editPrice= document.getElementById('editPrice');
  const editDesc = document.getElementById('editDesc');
  const editErr  = document.getElementById('editErr');
  const saveBtn  = document.getElementById('saveBtn');

  function showErr(msg) {
    if (!editErr) return;
    editErr.textContent = msg;
    editErr.style.display = '';
  }

  function hideErr() {
    if (!editErr) return;
    editErr.style.display = 'none';
    editErr.textContent = '';
  }

  // ✅ Делегирование кликов: работает и для существующих, и для динамических кнопок
  dogsBody.addEventListener('click', async (e) => {
    const btn = e.target.closest('button[data-act]');
    if (!btn) return;

    const act = btn.dataset.act;
    const id = btn.dataset.id;
    if (!id) return;

    // Найдём текущую строку, чтобы потом обновлять/удалять без reload
    const row = btn.closest('tr');

    try {
      if (act === 'del') {
        if (!confirm('Удалить собаку?')) return;
        await api('../api/admin/dog_delete.php', { id: Number(id) });
        if (row) row.remove();
        return;
      }

      if (act === 'edit') {
        const dog = await (await fetch(`../api/dog.php?id=${encodeURIComponent(id)}`)).json();

        editId.value = dog.id;
        editName.value = dog.name || '';
        editPrice.value = dog.price || 0;
        editDesc.value = dog.description || '';
        hideErr();

        // запомним строку, которую редактируем
        editModalEl.dataset.rowId = String(dog.id);

        editModal.show();
        return;
      }
    } catch (err) {
      console.error(err);
      alert(err?.data?.error || err.message || 'Ошибка');
    }
  });

  // ✅ Сохранение (AJAX)
  if (saveBtn) {
    saveBtn.addEventListener('click', async () => {
      hideErr();

      const id = Number(editId.value);
      const name = (editName.value || '').trim();
      const price = Number(editPrice.value || 0);
      const description = (editDesc.value || '').trim();

      try {
        await api('../api/admin/dog_update.php', { id, name, price, description });

        // Обновим строку в таблице (без перезагрузки)
        const rowId = editModalEl.dataset.rowId;
        if (rowId) {
          const tr = dogsBody.querySelector(`button[data-id="${rowId}"]`)?.closest('tr');
          if (tr) {
            // В твоей таблице колонки: ID | Имя | Порода | Создано | Действия
            // Имя — 2-я колонка (index 1)
            tr.children[1].textContent = name;
          }
        }

        editModal.hide();
      } catch (err) {
        console.error(err);
        showErr(err?.data?.error || err.message || 'Ошибка сохранения');
      }
    });
  }
});
