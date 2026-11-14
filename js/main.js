(function () {
  'use strict';

  /* ---------- Menú desplegable ---------- */
  var menuButton = document.getElementById('menuButton');
  var menu = document.getElementById('menu');

  function cerrarMenu() {
    menu.classList.remove('show');
    menuButton.setAttribute('aria-expanded', 'false');
  }

  menuButton.addEventListener('click', function () {
    var abierto = menu.classList.toggle('show');
    menuButton.setAttribute('aria-expanded', String(abierto));
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && menu.classList.contains('show')) {
      cerrarMenu();
      menuButton.focus();
    }
  });

  document.addEventListener('click', function (e) {
    if (!menu.contains(e.target) && !menuButton.contains(e.target)) {
      cerrarMenu();
    }
  });

  /* ---------- Tema claro / oscuro (se recuerda entre páginas) ---------- */
  var toggleTema = document.getElementById('toggle-modo');

  function actualizarIcono() {
    toggleTema.textContent = document.body.classList.contains('modo-claro') ? '🌙' : '🌓';
  }

  try {
    if (localStorage.getItem('tema') === 'claro') {
      document.body.classList.add('modo-claro');
    }
  } catch (err) { /* almacenamiento no disponible */ }
  actualizarIcono();

  toggleTema.addEventListener('click', function () {
    var claro = document.body.classList.toggle('modo-claro');
    try { localStorage.setItem('tema', claro ? 'claro' : 'oscuro'); } catch (err) {}
    actualizarIcono();
  });

  /* ---------- Fecha y hora en tiempo real (pie de página) ---------- */
  var fechaHora = document.getElementById('fecha-hora');

  function mostrarFechaHora() {
    var ahora = new Date();
    fechaHora.textContent = '🕒 ' + ahora.toLocaleString('es-AR', {
      weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
      hour: '2-digit', minute: '2-digit', second: '2-digit'
    });
  }

  if (fechaHora) {
    mostrarFechaHora();
    setInterval(mostrarFechaHora, 1000);
  }

  /* ---------- Botones de demostración (tienda) ---------- */
  document.querySelectorAll('[data-accion="comprar"]').forEach(function (boton) {
    boton.addEventListener('click', function () {
      alert('Producto agregado correctamente.');
    });
  });
})();
