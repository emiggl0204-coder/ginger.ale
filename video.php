<?php
$titulo_pagina = 'Video';
$pagina_activa = 'video';
require_once __DIR__ . '/includes/header.php';
?>
<main id="contenido">
<section id="video" class="page-top">
<div class="container">
<h2 class="section-title">Conocé <?= e($nombre_sitio) ?> en Video</h2>
<figure>
<div class="video-wrapper">
<iframe src="https://www.youtube.com/embed/Y_rcvP8LJYc" title="Clase de coctelería - Curso profesional de bartender" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<figcaption>Un vistazo a las técnicas de coctelería que se enseñan en nuestros cursos: preparación, herramientas y servicio profesional de barra.</figcaption>
</figure>
</div>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
