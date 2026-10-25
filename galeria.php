<?php
$titulo_pagina = 'Galería';
$pagina_activa = 'galeria';
$scripts_extra = ['js/galeria.js'];
require_once __DIR__ . '/includes/header.php';

$base = 'https://images.unsplash.com/';
$fotos = [
    ['photo-1514362545857-3bc16c4c7d1b', 'Coctelería 1'],
    ['photo-1517701550927-30cf4ba1fcef', 'Café 1'],
    ['photo-1470337458703-46ad1756a187', 'Coctelería 2'],
    ['photo-1495474472287-4d71bcdd2085', 'Café 2'],
    ['photo-1511578314322-379afb476865', 'Evento con barra móvil'],
    ['photo-1511920170033-f8396924c348', 'Máquina de café profesional'],
];
?>
<main id="contenido">
<section id="galeria" class="page-top">
<div class="container">
<h2 class="section-title">Galería</h2>
<div class="galeria" id="galeria-contenedor">
<?php foreach ($fotos as $i => [$id, $alt]): ?>
<img src="<?= e($base . $id) ?>?q=80&amp;w=400&amp;auto=format&amp;fit=crop" alt="<?= e($alt) ?>" data-index="<?= (int) $i ?>" tabindex="0" role="button" loading="lazy">
<?php endforeach; ?>
</div>
</div>
</section>
</main>
<div class="lightbox" id="lightbox">
<span class="cerrar" id="cerrar-lightbox">&times;</span>
<button class="nav prev" id="prev-img" type="button" aria-label="Imagen anterior">&#10094;</button>
<button class="nav next" id="next-img" type="button" aria-label="Imagen siguiente">&#10095;</button>
<img id="lightbox-img" src="" alt="Imagen ampliada">
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
