</main>
<footer>
<p>&copy; <?= htmlspecialchars($config['YEAR'] ?? date('Y'), ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($nombre_sitio ?? 'Ginger Ale', ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($tagline ?? 'Escuela de Coctelería y Barismo', ENT_QUOTES, 'UTF-8') ?>. Todos los derechos reservados.</p>
<p style="margin-top:8px;font-size:0.9rem;color:#aaa;" id="fecha-hora"></p>
</footer>

<div class="lightbox" id="lightbox">
<span class="cerrar" id="cerrar-lightbox">&times;</span>
<button class="nav prev" id="prev-img">&#10094;</button>
<button class="nav next" id="next-img">&#10095;</button>
<img id="lightbox-img" src="" alt="Imagen ampliada">
</div>

<button class="modo-oscuro-toggle" id="toggle-modo" aria-label="Cambiar tema">🌓</button>

<script src="js/main.js"></script>
</body>
</html>
