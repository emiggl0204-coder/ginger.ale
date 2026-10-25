<?php
$titulo_pagina = 'Inicio';
$pagina_activa = 'inicio';
require_once __DIR__ . '/includes/header.php';
$u = 'https://images.unsplash.com/';
?>
<main id="contenido">
<section id="inicio" class="hero">
<div class="hero-content">
<h1>Escuela de Coctelería y Barismo</h1>
<p>Formación profesional para bartenders, baristas y amantes del café. Aprendé mediante clases prácticas, equipamiento profesional y certificación.</p>
<a href="cursos.php" class="btn">Ver Cursos</a>
</div>
</section>
<section id="propuesta">
<div class="container">
<h2 class="section-title">Bienvenido a <?= e($nombre_sitio) ?></h2>
<p class="page-intro">Todo lo que necesitás para formarte y trabajar en el mundo de la coctelería y el café.</p>
<div class="cards">
<a class="card" href="cursos.php#presenciales">
<img src="<?= $u ?>photo-1517701550927-30cf4ba1fcef?q=80&amp;w=1200&amp;auto=format&amp;fit=crop" alt="Barista preparando un café espresso" loading="lazy">
<div class="card-content"><h3>Cursos presenciales</h3><p>Barista, bartender e intensivos con práctica real en barra.</p></div>
</a>
<a class="card" href="cursos.php#virtuales">
<img src="<?= $u ?>photo-1495474472287-4d71bcdd2085?q=80&amp;w=1200&amp;auto=format&amp;fit=crop" alt="Alumno cursando una clase virtual" loading="lazy">
<div class="card-content"><h3>Cursos virtuales</h3><p>Estudiá a tu ritmo con clases grabadas y acompañamiento docente.</p></div>
</a>
<a class="card" href="eventos.php">
<img src="<?= $u ?>photo-1511578314322-379afb476865?q=80&amp;w=1200&amp;auto=format&amp;fit=crop" alt="Barra móvil en un evento" loading="lazy">
<div class="card-content"><h3>Barra móvil y eventos</h3><p>Servicio de coctelería y café para tus eventos.</p></div>
</a>
<a class="card" href="productos.php">
<img src="<?= $u ?>photo-1578662996442-48f60103fc96?q=80&amp;w=1200&amp;auto=format&amp;fit=crop" alt="Kit de bartender" loading="lazy">
<div class="card-content"><h3>Productos e insumos</h3><p>Kits, cafeteras y accesorios profesionales.</p></div>
</a>
</div>
</div>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
