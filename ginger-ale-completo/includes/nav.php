<?php
// Determinar página actual para marcar el ítem activo
$pagina_actual = basename($_SERVER['PHP_SELF'] ?? 'index.php');
?>
<nav aria-label="Menú principal">
<button class="menu-btn" id="menuButton" aria-label="Abrir menú de navegación" aria-controls="menu" aria-expanded="false">☰</button>
<ul class="dropdown" id="menu" role="menu">
<li role="none"><a href="index.php" role="menuitem" class="<?= $pagina_actual === 'index.php' ? 'active' : '' ?>">Inicio</a></li>
<li role="none"><a href="cursos.php" role="menuitem" class="<?= $pagina_actual === 'cursos.php' ? 'active' : '' ?>">Cursos</a></li>
<li role="none"><a href="virtuales.php" role="menuitem" class="<?= $pagina_actual === 'virtuales.php' ? 'active' : '' ?>">Cursos Virtuales</a></li>
<li role="none"><a href="profesores.php" role="menuitem" class="<?= $pagina_actual === 'profesores.php' ? 'active' : '' ?>">Profesores</a></li>
<li role="none"><a href="eventos.php" role="menuitem" class="<?= $pagina_actual === 'eventos.php' ? 'active' : '' ?>">Eventos</a></li>
<li role="none"><a href="productos.php" role="menuitem" class="<?= $pagina_actual === 'productos.php' ? 'active' : '' ?>">Productos</a></li>
<li role="none"><a href="busqueda.php" role="menuitem" class="<?= $pagina_actual === 'busqueda.php' ? 'active' : '' ?>">Buscar</a></li>
<li role="none"><a href="contacto.php" role="menuitem" class="<?= $pagina_actual === 'contacto.php' ? 'active' : '' ?>">Contacto</a></li>
</ul>
</nav>
