<?php
$titulo_pagina = 'Productos e Insumos';
$pagina_activa = 'productos';
require_once __DIR__ . '/includes/header.php';
?>
<main id="contenido">
<section id="productos" class="page-top">
<div class="container">
<h2 class="section-title">Productos e Insumos</h2>
<div class="cards">
<?php foreach (items_de('productos') as $item) { render_card($item, $ruta_base); } ?>
</div>
</div>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
