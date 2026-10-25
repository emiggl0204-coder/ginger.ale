<?php
$titulo_pagina = 'Cursos';
$pagina_activa = 'cursos';
require_once __DIR__ . '/includes/header.php';
?>
<main id="contenido">
<section id="presenciales" class="page-top">
<div class="container">
<h2 class="section-title">Cursos Presenciales</h2>
<div class="cards">
<?php foreach (items_de('cursos') as $item) { render_card($item, $ruta_base); } ?>
</div>
</div>
</section>
<section id="virtuales">
<div class="container">
<h2 class="section-title">Cursos Virtuales</h2>
<div class="cards">
<?php foreach (items_de('virtuales') as $item) { render_card($item, $ruta_base); } ?>
</div>
</div>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
