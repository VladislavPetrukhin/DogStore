/* DogStore main.js — интерактивность для лабораторной работы
 *
 * Покрывает требования:
 * 1) Интерактивное меню/таблица (фильтр/сортировка каталога)
 * 2) Формы (гостевая книга)
 * 3) Проверка корректности (клиентская валидация)
 * 4) Обработка данных формы и генерация новой страницы (отчёт в новом окне)
 * 5) Галерея и свойства объекта в новом окне
 * 6) Три вида внедрения JS:
 *    - внешний файл <script src="assets/js/main.js">;
 *    - обработчик события onclick у ссылки "Фильтры каталога";
 *    - гипертекстовая ссылка <a href="javascript:generateCoupon()">Купон</a>
 */

document.addEventListener('DOMContentLoaded', function () {

  // ========== 1) SLICK CAROUSEL ==========
  if (window.jQuery) {
    const hasSlick = !!(jQuery.fn && jQuery.fn.slick);

    const $mainSlider = jQuery('.dog-carousel.main-slider');
    const $thumbsSlider = jQuery('.dog-thumbs.thumb-slider');

    if (hasSlick && $mainSlider.length) {

      // --- главный слайдер ---
      $mainSlider.on('init', function () {
        $mainSlider.find('.slick-slide img')
          .css('cursor', 'zoom-in')
          .on('click', function () {
            openImageProps(this);
          });
      });

      $mainSlider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: true,
        dots: true,
        lazyLoad: 'ondemand',
        pauseOnHover: true,
        adaptiveHeight: true,
        asNavFor: '.dog-thumbs.thumb-slider'
      });

      // --- превью-слайдер ---
      if ($thumbsSlider.length) {
        $thumbsSlider.slick({
          slidesToShow: 5,
          slidesToScroll: 1,
          asNavFor: '.dog-carousel.main-slider',
          focusOnSelect: true,
          infinite: true,
          responsive: [
            { breakpoint: 992, settings: { slidesToShow: 4 } },
            { breakpoint: 768, settings: { slidesToShow: 3 } },
            { breakpoint: 520, settings: { slidesToShow: 2 } }
          ]
        });
      }

      // --- управление с клавиатуры ---
      document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') $mainSlider.slick('slickPrev');
        if (e.key === 'ArrowRight') $mainSlider.slick('slickNext');
      });

    } else if (!hasSlick && document.querySelector('.dog-carousel.main-slider')) {
      // slick.js не подцепился — аккуратный fallback без ошибок
      const msg = document.createElement('div');
      msg.textContent = 'Slick не найден. Проверьте файлы в assets/vendor/';
      msg.style.cssText =
        'padding:12px;margin:12px 0;border:1px solid #933;background:#311;color:#fbb;border-radius:8px;';
      const mainEl = document.querySelector('main') || document.body;
      mainEl.prepend(msg);
    }
  }

  // ========== 2) Подсказки для обязательных полей ==========
  document.querySelectorAll('input[required], textarea[required]').forEach(el => {
    el.addEventListener('focus', () => el.dataset.tipShown = '1');
    el.addEventListener('mouseover', () => {
      if (!el.dataset.tipShown) {
        el.title = 'Поле обязательно для заполнения';
      }
    });
  });

  // ========== 3) Гостевая книга: валидация и отчёт ==========
  const form = document.getElementById('guest-form');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!validateForm(form)) return;

      const data = Object.fromEntries(new FormData(form).entries());
      const w = window.open('', '_blank');
      const time = new Date().toLocaleString();
      const html = `<!DOCTYPE html>
<html lang="ru"><head>
<meta charset="UTF-8">
<title>Спасибо за отзыв — DogStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/css/style-urbanpaw.css">
</head>
<body class="container">
  <h1>Спасибо, ${escapeHtml(data.name)}!</h1>
  <p>Мы получили ваш отзыв от <strong>${time}</strong>.</p>
  <article class="card">
    <h2>Краткий отчёт</h2>
    <ul>
      <li>Email: ${escapeHtml(data.email)}</li>
      <li>Оценка: ${escapeHtml(data.rating || '—')}</li>
      <li>Сообщение:</li>
    </ul>
    <pre class="pre">${escapeHtml(data.message)}</pre>
  </article>
  <p><a href="index.html">Вернуться на сайт</a></p>
</body></html>`;
      w.document.open();
      w.document.write(html);
      w.document.close();
      form.reset();
    });
  }

  // ========== 4) Каталог: фильтры и сортировка ==========
  setupCatalogInteractions();
});


// ======= Глобальные функции (доступны для javascript: и onclick) =======

// Кнопочная панель фильтров каталога
function toggleFilters() {
  const panel = document.getElementById('catalog-filters');
  if (!panel) {
    alert('Фильтры доступны на странице каталога.');
    return;
  }
  panel.hidden = !panel.hidden;
}

// Генератор купона — вызывается из гиперссылки javascript:
function generateCoupon() {
  const code = 'DOG-' + Math.random().toString(36).slice(2, 8).toUpperCase();
  alert('Ваш персональный купон на 10%: ' + code);
}

// Открыть «свойства объекта» изображения (используется в галерее)
function openImageProps(imgEl) {
  const w = window.open('', '_blank', 'width=480,height=360');
  const details = `
    <ul>
      <li>alt: ${escapeHtml(imgEl.alt)}</li>
      <li>naturalWidth×naturalHeight: ${imgEl.naturalWidth}×${imgEl.naturalHeight}</li>
      <li>src: ${escapeHtml(imgEl.src)}</li>
    </ul>`;
  w.document.write(`<!DOCTYPE html><meta charset="UTF-8"><title>Свойства изображения</title>
  <body class="container"><h1>Свойства</h1>${details}<p><img src="${imgEl.src}" style="max-width:100%"></p></body>`);
  w.document.close();
}


// ======= Валидация формы гостевой =======
function validateForm(form) {
  let ok = true;
  const setErr = (name, msg) => {
    const span = form.querySelector(`.error[data-for="${name}"]`);
    if (span) span.textContent = msg || '';
  };
  ['name', 'email', 'message', 'agree'].forEach(n => setErr(n, ''));

  const name = form.elements['name'].value.trim();
  if (name.length < 2) { setErr('name', 'Минимум 2 символа'); ok = false; }

  const email = form.elements['email'].value.trim();
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { setErr('email', 'Введите корректный email'); ok = false; }

  const msg = form.elements['message'].value.trim();
  if (msg.length < 10) { setErr('message', 'Минимум 10 символов'); ok = false; }

  const agree = form.elements['agree'].checked;
  if (!agree) { setErr('agree', 'Нужно согласие'); ok = false; }

  return ok;
}


// ======= Каталог: фильтрация и сортировка =======
function setupCatalogInteractions() {
  const catalog = document.querySelector('[data-catalog]');
  if (!catalog) return;

  // Создать панель фильтров, если её нет
  let panel = document.getElementById('catalog-filters');
  if (!panel) {
    panel = document.createElement('section');
    panel.id = 'catalog-filters';
    panel.className = 'filters card';
    panel.innerHTML = `
      <h2>Фильтры каталога</h2>
      <div class="controls">
        <label>Порода:
          <select id="breedFilter">
            <option value="">Все</option>
            <option>Самоед</option>
            <option>Хаски</option>
            <option>Лабрадор</option>
            <option>Овчарка</option>
            <option>Дог</option>
          </select>
        </label>
        <button type="button" id="sortPrice">Сортировать по цене</button>
        <button type="button" id="clearFilters">Сбросить</button>
      </div>
    `;
    catalog.parentElement.insertBefore(panel, catalog);
  }
  panel.hidden = true;

  const items = Array.from(catalog.querySelectorAll('[data-item]'));
  let asc = true;

  document.getElementById('sortPrice').addEventListener('click', () => {
    const sorted = items.slice().sort((a, b) => {
      const pa = parsePrice(a.dataset.price);
      const pb = parsePrice(b.dataset.price);
      return asc ? pa - pb : pb - pa;
    });
    asc = !asc;
    sorted.forEach(el => catalog.appendChild(el));
  });

  document.getElementById('breedFilter').addEventListener('change', (e) => {
    const val = e.target.value;
    items.forEach(el => {
      el.hidden = val && el.dataset.breed !== val;
    });
  });

  document.getElementById('clearFilters').addEventListener('click', () => {
    document.getElementById('breedFilter').value = '';
    items.forEach(el => el.hidden = false);
  });
}

function parsePrice(txt) {
  const num = (txt || '').toString().replace(/[^\d]/g, '');
  return parseInt(num || '0', 10);
}

function escapeHtml(s) {
  return String(s).replace(/[&<>"']/g, ch => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  })[ch]);
}
