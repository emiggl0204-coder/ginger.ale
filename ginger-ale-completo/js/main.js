// Ginger Ale - Scripts principales

// 1. Fecha y hora en tiempo real
function mostrarFechaHora() {
  const ahora = new Date();
  const opciones = { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric', 
    hour: '2-digit', 
    minute: '2-digit', 
    second: '2-digit' 
  };
  const fechaStr = ahora.toLocaleDateString('es-AR', opciones);
  const el = document.getElementById('fecha-hora');
  if (el) el.textContent = '🕒 ' + fechaStr;
}
mostrarFechaHora();
setInterval(mostrarFechaHora, 1000);

// 2. Menú interactivo
const menuButton = document.getElementById("menuButton");
const menu = document.getElementById("menu");

function toggleMenu() {
  if (!menuButton || !menu) return;
  const expanded = menuButton.getAttribute("aria-expanded") === "true";
  menuButton.setAttribute("aria-expanded", !expanded);
  menu.classList.toggle("show");
}

if (menuButton) {
  menuButton.addEventListener("click", toggleMenu);
  menuButton.addEventListener("keydown", function(e) {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      toggleMenu();
    }
  });
}

document.addEventListener("keydown", function(e) {
  if (e.key === "Escape" && menu) {
    menu.classList.remove("show");
    if (menuButton) {
      menuButton.setAttribute("aria-expanded", "false");
      menuButton.focus();
    }
  }
});

document.addEventListener("click", function(e) {
  if (menu && menuButton && !menu.contains(e.target) && !menuButton.contains(e.target)) {
    menu.classList.remove("show");
    menuButton.setAttribute("aria-expanded", "false");
  }
});

document.querySelectorAll(".dropdown a").forEach(link => {
  link.addEventListener("click", () => {
    if (menu) menu.classList.remove("show");
    if (menuButton) menuButton.setAttribute("aria-expanded", "false");
  });
});

// 3. Galería de imágenes con lightbox y navegación
const imagenesGaleria = document.querySelectorAll('.galeria img');
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');
const cerrarLightbox = document.getElementById('cerrar-lightbox');
const prevBtn = document.getElementById('prev-img');
const nextBtn = document.getElementById('next-img');
let indiceActual = 0;

function abrirLightbox(index) {
  if (!lightbox || !lightboxImg || !imagenesGaleria.length) return;
  indiceActual = index;
  lightboxImg.src = imagenesGaleria[index].src.replace('w=400', 'w=1200');
  lightbox.classList.add('open');
}

function cerrarLightboxFn() {
  if (lightbox) lightbox.classList.remove('open');
}

function cambiarImagen(delta) {
  if (!imagenesGaleria.length || !lightboxImg) return;
  const total = imagenesGaleria.length;
  indiceActual = (indiceActual + delta + total) % total;
  lightboxImg.src = imagenesGaleria[indiceActual].src.replace('w=400', 'w=1200');
}

imagenesGaleria.forEach((img, i) => {
  img.addEventListener('click', () => abrirLightbox(i));
});

if (cerrarLightbox) cerrarLightbox.addEventListener('click', cerrarLightboxFn);

if (lightbox) {
  lightbox.addEventListener('click', function(e) {
    if (e.target === this) cerrarLightboxFn();
  });
}

if (prevBtn) prevBtn.addEventListener('click', function(e) { e.stopPropagation(); cambiarImagen(-1); });
if (nextBtn) nextBtn.addEventListener('click', function(e) { e.stopPropagation(); cambiarImagen(1); });

document.addEventListener('keydown', function(e) {
  if (!lightbox || !lightbox.classList.contains('open')) return;
  if (e.key === 'Escape') cerrarLightboxFn();
  if (e.key === 'ArrowLeft') cambiarImagen(-1);
  if (e.key === 'ArrowRight') cambiarImagen(1);
});

// 4. Cambiar tema (modo oscuro/claro)
const toggleTema = document.getElementById('toggle-modo');
if (toggleTema) {
  toggleTema.addEventListener('click', function() {
    document.body.classList.toggle('modo-claro');
    this.textContent = document.body.classList.contains('modo-claro') ? '🌙' : '🌓';
  });
}

// 5. Navegación suave
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener("click", function(e) {
    const href = this.getAttribute("href");
    if (href === "#") return;
    const destino = document.querySelector(href);
    if (destino) {
      e.preventDefault();
      destino.scrollIntoView({ behavior: "smooth" });
    }
  });
});
