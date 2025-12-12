async function uploadPhoto(file) {
  const fd = new FormData();
  fd.append('photo', file);

  const r = await fetch('../api/admin/gallery_upload.php', {
    method: 'POST',
    body: fd
  });

  const data = await r.json().catch(() => ({}));
  if (!r.ok || !data.ok) {
    throw new Error(data.error || `HTTP ${r.status}`);
  }
  return data.photo;
}

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('galleryUploadForm');
  const input = document.getElementById('galleryFile');
  const err = document.getElementById('galleryErr');
  const tbody = document.getElementById('galleryBody');

  if (!form || !input || !tbody) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    err.style.display = 'none';

    const file = input.files?.[0];
    if (!file) {
      err.textContent = 'Выбери файл 🙂';
      err.style.display = 'block';
      return;
    }

    try {
      const p = await uploadPhoto(file);

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>
          <img src="uploads/gallery/${p.filename}" style="width:120px; height:90px; object-fit:cover; border-radius:6px;">
        </td>
        <td>${p.uploaded_at}</td>
        <td>
          <a href="gallery_delete.php?id=${p.id}" class="btn btn-red" onclick="return confirm('Удалить фото?');">Удалить</a>
        </td>
      `;

      tbody.prepend(tr);
      form.reset();

    } catch (e2) {
      err.textContent = e2.message;
      err.style.display = 'block';
    }
  });
});
