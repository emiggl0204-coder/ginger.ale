<?php
$titulo_pagina = 'Profesores';
$pagina_activa = 'profesores';
require_once __DIR__ . '/includes/header.php';
?>
<main id="contenido">
<section id="profesores" class="page-top">
<div class="container">
<h2 class="section-title">Nuestro Equipo</h2>
<div class="cards">
<?php foreach (items_de('profesores') as $item) { render_card($item, $ruta_base); } ?>
</div>
</div>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
