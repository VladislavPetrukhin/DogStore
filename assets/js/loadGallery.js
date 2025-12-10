document.addEventListener("DOMContentLoaded", () => {
    const main = document.querySelector('.dog-carousel.main-slider');
    const thumbs = document.querySelector('.dog-thumbs.thumb-slider');

    if (!main || !thumbs) return;

    fetch('/dynamic-api/gallery.php')
        .then(r => r.json())
        .then(rows => {
            if (!rows || !rows.length) {
                main.innerHTML = '<p class="text-muted">Пока нет фотографий.</p>';
                return;
            }

            rows.forEach(p => {
                const url = `/dogpanel/uploads/gallery/${p.photo}`;

                const big = document.createElement('div');
                big.innerHTML = `
                    <img src="${url}" alt=""
                         class="img-fluid rounded-4"
                         style="width:100%; height:550px; object-fit:cover;">
                `;
                main.appendChild(big);

                const small = document.createElement('div');
                small.innerHTML = `
                    <img src="${url}" alt=""
                         class="img-fluid rounded-3"
                         style="width:100%; height:100px; object-fit:cover;">
                `;
                thumbs.appendChild(small);
            });

            // Инициализируем slick, когда всё готово
            const $main = window.jQuery('.dog-carousel.main-slider');
            const $thumbs = window.jQuery('.dog-thumbs.thumb-slider');

            $main.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true,
                dots: true,
                adaptiveHeight: true,
                asNavFor: '.dog-thumbs.thumb-slider'
            });

            $thumbs.slick({
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
        })
        .catch(err => {
            console.error('Gallery load error:', err);
        });
});
