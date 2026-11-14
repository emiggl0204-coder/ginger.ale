(function () {
  'use strict';

  var imagenes = document.querySelectorAll('.galeria img');
  var lightbox = document.getElementById('lightbox');
  var lightboxImg = document.getElementById('lightbox-img');
  var cerrar = document.getElementById('cerrar-lightbox');
  var prev = document.getElementById('prev-img');
  var next = document.getElementById('next-img');
  var actual = 0;

  if (!lightbox || imagenes.length === 0) { return; }

  function mostrar(i) {
    actual = (i + imagenes.length) % imagenes.length;
    lightboxImg.src = imagenes[actual].src.replace('w=400', 'w=1200');
    lightboxImg.alt = imagenes[actual].alt;
  }

  function abrir(i) {
    mostrar(i);
    lightbox.classList.add('open');
  }

  function cerrarLightbox() {
    lightbox.classList.remove('open');
  }

  imagenes.forEach(function (img, i) {
    img.addEventListener('click', function () { abrir(i); });
    img.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); abrir(i); }
    });
  });

  cerrar.addEventListener('click', cerrarLightbox);
  lightbox.addEventListener('click', function (e) { if (e.target === lightbox) { cerrarLightbox(); } });
  prev.addEventListener('click', function (e) { e.stopPropagation(); mostrar(actual - 1); });
  next.addEventListener('click', function (e) { e.stopPropagation(); mostrar(actual + 1); });

  document.addEventListener('keydown', function (e) {
    if (!lightbox.classList.contains('open')) { return; }
    if (e.key === 'Escape') { cerrarLightbox(); }
    if (e.key === 'ArrowLeft') { mostrar(actual - 1); }
    if (e.key === 'ArrowRight') { mostrar(actual + 1); }
  });
})();
