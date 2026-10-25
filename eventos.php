<?php
$titulo_pagina = 'Barra Móvil y Eventos';
$pagina_activa = 'eventos';
require_once __DIR__ . '/includes/header.php';
?>
<main id="contenido">
<section id="eventos" class="page-top">
<div class="container">
<h2 class="section-title">Barra Móvil y Eventos</h2>
<div class="cards">
<?php foreach (items_de('eventos') as $item) { render_card($item, $ruta_base); } ?>
</div>
</div>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
