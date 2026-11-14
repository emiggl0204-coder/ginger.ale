<?php
/**
 * nav.php — cabecera con logo y menú principal.
 * Marca con la clase "active" (y aria-current) el ítem cuya clave coincide con $pagina_activa.
 */
$menu = [
    'inicio'     => ['Inicio',     'index.php'],
    'cursos'     => ['Cursos',     'cursos.php'],
    'profesores' => ['Profesores', 'profesores.php'],
    'eventos'    => ['Eventos',    'eventos.php'],
    'productos'  => ['Productos',  'productos.php'],
    'video'      => ['Video',      'video.php'],
    'galeria'    => ['Galería',    'galeria.php'],
    'buscar'     => ['Buscar',     'clase5/buscar.php'],
    'contacto'   => ['Contacto',   'clase5/contacto.php'],
];
?>
<header>
<a class="logo" href="<?= e($ruta_base) ?>index.php"><?= e(mb_strtoupper(APP_NAME)) ?></a>
<nav aria-label="Menú principal">
<button class="menu-btn" id="menuButton" type="button" aria-label="Abrir menú de navegación" aria-controls="menu" aria-expanded="false">☰</button>
<ul class="dropdown" id="menu">
<?php foreach ($menu as $clave => [$etiqueta, $url]): $activo = ($clave === $pagina_activa); ?>
<li><a href="<?= e($ruta_base . $url) ?>"<?= $activo ? ' class="active" aria-current="page"' : '' ?>><?= e($etiqueta) ?></a></li>
<?php endforeach; ?>
</ul>
</nav>
</header>
