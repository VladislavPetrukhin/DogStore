// stats.js — динамические диаграммы для Dog Store (Chart.js)
// Источник данных: /api/dogs.php
// В расчётах участвуют ТОЛЬКО собаки с указанной породой и ценой

// Фиксированная палитра (последний цвет — для "Другие")
const COLORS = [
  '#4FC3F7', // голубой
  '#FF6B81', // розовый
  '#FFA94D', // оранжевый
  '#FFD166', // жёлтый
  '#4DD0E1', // бирюзовый
  '#9B7EFB', // фиолетовый
  '#74C0FC', // синий
  '#63E6BE', // мятный
  '#ADB5BD'  // серый — "Другие"
];

async function fetchDogs() {
  const r = await fetch('api/dogs.php', {
    headers: { 'Accept': 'application/json' }
  });
  if (!r.ok) throw new Error('HTTP ' + r.status);
  return await r.json();
}

function groupByBreed(dogs) {
  const map = new Map();

  for (const d of dogs) {
    if (!d.breed || typeof d.breed !== 'string' || d.breed.trim() === '') continue;

    const price = Number(d.price);
    if (!Number.isFinite(price) || price <= 0) continue;

    const breed = d.breed.trim();

    if (!map.has(breed)) {
      map.set(breed, { count: 0, sumPrice: 0 });
    }

    const x = map.get(breed);
    x.count += 1;
    x.sumPrice += price;
  }

  return map;
}

function toTopN(map, n = 8) {
  const arr = Array.from(map.entries())
    .sort((a, b) => b[1].count - a[1].count);

  const top = arr.slice(0, n);
  const rest = arr.slice(n);

  if (rest.length) {
    let restCount = 0;
    let restSum = 0;

    for (const [, v] of rest) {
      restCount += v.count;
      restSum += v.sumPrice;
    }

    top.push(['Другие', { count: restCount, sumPrice: restSum }]);
  }

  return top;
}

function makePie(ctx, labels, data) {
  const total = data.reduce((a, b) => a + b, 0);

  const colors = labels.map((l, i) =>
    l === 'Другие' ? COLORS[COLORS.length - 1] : COLORS[i % (COLORS.length - 1)]
  );

  return new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels,
      datasets: [{
        data,
        backgroundColor: colors,
        borderColor: '#111',
        borderWidth: 2,
        hoverOffset: 14
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' },
        tooltip: {
          callbacks: {
            label: (ctx) => {
              const value = ctx.parsed;
              const percent = total
                ? ((value / total) * 100).toFixed(1)
                : 0;
              return `${ctx.label}: ${value} (${percent}%)`;
            }
          }
        }
      }
    }
  });
}

function makeBar(ctx, labels, data) {
  const colors = labels.map((l, i) =>
    l === 'Другие' ? COLORS[COLORS.length - 1] : COLORS[i % (COLORS.length - 1)]
  );

  return new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Средняя цена, ₽',
        data,
        backgroundColor: colors
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: (ctx) => `${ctx.parsed.y} ₽`
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: v => v + ' ₽'
          }
        }
      }
    }
  });
}

document.addEventListener('DOMContentLoaded', async () => {
  const cBreeds = document.getElementById('chartBreeds');
  const cAvg = document.getElementById('chartAvgPrice');
  const hint = document.getElementById('chartBreedsHint');

  if (!cBreeds || !cAvg) return;

  try {
    const dogs = await fetchDogs();

    if (!Array.isArray(dogs) || dogs.length === 0) {
      if (hint) hint.textContent = 'Каталог пуст — недостаточно данных.';
      return;
    }

    const grouped = groupByBreed(dogs);

    if (grouped.size === 0) {
      if (hint) {
        hint.textContent =
          'Нет собак с одновременно указанной породой и ценой.';
      }
      return;
    }

    const top = toTopN(grouped, 8);

    const labels = top.map(([k]) => k);
    const counts = top.map(([, v]) => v.count);
    const avgPrices = top.map(([, v]) =>
      Math.round(v.sumPrice / v.count)
    );

    makePie(cBreeds, labels, counts);
    makeBar(cAvg, labels, avgPrices);

    if (hint) {
      hint.textContent =
        `Показаны топ-${Math.min(8, grouped.size)} пород по количеству ` +
        `(остальные объединены в «Другие»). Всего позиций: ${dogs.length}.`;
    }
  } catch (e) {
    console.error(e);
    if (hint) {
      hint.textContent =
        'Ошибка загрузки данных. Проверь API и запуск сайта через сервер.';
    }
  }
});
