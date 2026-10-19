<?php
$titulo_pagina = "Inicio | Ginger Ale - Escuela de Coctelería y Barismo";
require_once 'includes/header.php';
?>

<section id="inicio" class="hero">
<div class="hero-content">
<h1>Escuela de Coctelería y Barismo</h1>
<p>Formación profesional para bartenders, baristas y amantes del café. Aprendé mediante clases prácticas, equipamiento profesional y certificación.</p>
<a href="cursos.php" class="btn">Ver Cursos</a>
</div>
</section>

<section id="cursos">
<div class="container">
<h2 class="section-title">Cursos Presenciales</h2>
<div class="cards">
<article class="card">
<img src="https://images.unsplash.com/photo-1517701550927-30cf4ba1fcef?q=80&w=1200&auto=format&fit=crop" alt="Barista preparando un café espresso en una máquina profesional">
<div class="card-content"><h3>Barista Profesional</h3><p>Aprendé espresso, latte art, molienda, extracción, texturizado de leche y calibración de molinos.</p><a href="contacto.php?curso=barista" class="btn">Inscribirme</a></div>
</article>
<article class="card">
<img src="https://images.unsplash.com/photo-1470337458703-46ad1756a187?q=80&w=1200&auto=format&fit=crop" alt="Bartender preparando un cóctel profesional detrás de una barra">
<div class="card-content"><h3>Bartender Profesional</h3><p>Coctelería clásica, moderna, mixología, flair, servicio de barra y atención al cliente.</p><a href="contacto.php?curso=bartender" class="btn">Inscribirme</a></div>
</article>
<article class="card">
<img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?q=80&w=1200&auto=format&fit=crop" alt="Grupo de estudiantes practicando técnicas de coctelería">
<div class="card-content"><h3>Curso Intensivo</h3><p>Capacitación acelerada para comenzar a trabajar como bartender o barista en pocas semanas.</p><a href="contacto.php?curso=intensivo" class="btn">Inscribirme</a></div>
</article>
</div>
</div>
</section>

<section id="video">
<div class="container">
<h2 class="section-title">Conocé Ginger Ale en Video</h2>
<figure>
<div class="video-wrapper">
<iframe src="https://www.youtube.com/embed/Y_rcvP8LJYc" title="Clase de coctelería - Curso profesional de bartender" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<figcaption>Un vistazo a las técnicas de coctelería que se enseñan en nuestros cursos: preparación, herramientas y servicio profesional de barra.</figcaption>
</figure>
</div>
</section>

<section id="galeria" style="padding-top:40px;">
<div class="container">
<h2 class="section-title">Galería</h2>
<div class="galeria" id="galeria-contenedor">
<img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=400&auto=format&fit=crop" alt="Coctelería 1" data-index="0">
<img src="https://images.unsplash.com/photo-1517701550927-30cf4ba1fcef?q=80&w=400&auto=format&fit=crop" alt="Café 1" data-index="1">
<img src="https://images.unsplash.com/photo-1470337458703-46ad1756a187?q=80&w=400&auto=format&fit=crop" alt="Coctelería 2" data-index="2">
<img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=400&auto=format&fit=crop" alt="Café 2" data-index="3">
</div>
</div>
</section>

<?php require_once 'includes/footer.php'; ?>
