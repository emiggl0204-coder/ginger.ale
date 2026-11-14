<?php
/**
 * footer.php — pie de página y scripts JS.
 * Opcional: $scripts_extra = ['js/galeria.js'] para cargar scripts propios de una página.
 */
$ruta_base     = $ruta_base ?? '';
$scripts_extra = $scripts_extra ?? [];
?>
<footer>
<p>&copy; <?= date('Y') ?> <?= e(APP_NAME) ?> - <?= e(APP_DESCRIPTION) ?>. Todos los derechos reservados.</p>
<p class="footer-contacto">Contacto: <a href="mailto:<?= e(APP_EMAIL) ?>"><?= e(APP_EMAIL) ?></a></p>
<p class="fecha-hora" id="fecha-hora"></p>
</footer>
<button class="modo-oscuro-toggle" id="toggle-modo" type="button" aria-label="Cambiar tema">🌓</button>
<script src="<?= e($ruta_base) ?>js/main.js"></script>
<?php foreach ($scripts_extra as $script): ?>
<script src="<?= e($ruta_base . $script) ?>"></script>
<?php endforeach; ?>
</body>
</html>
