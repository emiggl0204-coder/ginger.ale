<?php
$titulo_pagina = "Cursos Presenciales | Ginger Ale";
require_once 'includes/header.php';
?>

<section style="padding-top:120px;">
<div class="container">
<h2 class="section-title">Cursos Presenciales</h2>
<div class="cards">
<article class="card">
<img src="https://images.unsplash.com/photo-1517701550927-30cf4ba1fcef?q=80&w=1200&auto=format&fit=crop" alt="Barista profesional">
<div class="card-content">
<h3>Barista Profesional</h3>
<p>Aprendé espresso, latte art, molienda, extracción, texturizado de leche y calibración de molinos. Duración: 8 clases.</p>
<a href="contacto.php?curso=barista" class="btn">Inscribirme</a>
</div>
</article>
<article class="card">
<img src="https://images.unsplash.com/photo-1470337458703-46ad1756a187?q=80&w=1200&auto=format&fit=crop" alt="Bartender profesional">
<div class="card-content">
<h3>Bartender Profesional</h3>
<p>Coctelería clásica, moderna, mixología, flair, servicio de barra y atención al cliente. Duración: 10 clases.</p>
<a href="contacto.php?curso=bartender" class="btn">Inscribirme</a>
</div>
</article>
<article class="card">
<img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?q=80&w=1200&auto=format&fit=crop" alt="Curso intensivo">
<div class="card-content">
<h3>Curso Intensivo</h3>
<p>Capacitación acelerada para comenzar a trabajar como bartender o barista en pocas semanas.</p>
<a href="contacto.php?curso=intensivo" class="btn">Inscribirme</a>
</div>
</article>
</div>
</div>
</section>

<?php require_once 'includes/footer.php'; ?>
