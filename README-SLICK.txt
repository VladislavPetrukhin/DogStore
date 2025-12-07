DogStore — локальная галерея на jQuery + Slick
==============================================

Что уже сделано:
  • Разметка под Slick (главный слайдер + лента миниатюр)
  • Подключения указывают на ЛОКАЛЬНЫЕ файлы:
      assets/vendor/jquery.min.js
      assets/vendor/slick.min.js
      assets/vendor/slick.css
      assets/vendor/slick-theme.css

Что нужно сделать на вашей машине (один раз):
  1) Скачайте jQuery 3.x (минимизированный) и сохраните как:
     assets/vendor/jquery.min.js
  2) Скачайте Slick 1.8.1 (файлы slick.min.js, slick.css, slick-theme.css) и поместите в:
     assets/vendor/
  3) Откройте gallery.html — стрелки/точки и миниатюры должны работать.
  4) Если не работает, на странице появится видимое предупреждение о том, что Slick не найден.

Советы:
  • Изображения для карусели лежат в assets/img/gal1.jpg … gal5.jpg — замените на свои.
  • Меню выровнено через flex + gap, чтобы пункты не «слипались» даже без классов.
