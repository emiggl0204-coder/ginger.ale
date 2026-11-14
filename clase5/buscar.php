<?php
/**
 * Clase 5 — Buscador del catálogo (método GET).
 * Parámetros: q (texto) y categoria (lista blanca de secciones).
 * Se sanitizan con filter_input() + limpiar() y se escapan con e() al imprimir.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/funciones.php';

$ruta_base     = '../';
$titulo_pagina = 'Buscar';
$pagina_activa = 'buscar';

$categorias = secciones_catalogo();
$q          = limpiar(filter_input(INPUT_GET, 'q', FILTER_UNSAFE_RAW));
$categoria  = limpiar(filter_input(INPUT_GET, 'categoria', FILTER_UNSAFE_RAW));
$enviado    = isset($_GET['q']) || isset($_GET['categoria']);
$errores    = [];
$resultados = [];

if ($enviado) {
    if ($categoria !== '' && !isset($categorias[$categoria])) {
        $errores[] = 'La categoría seleccionada no es válida.';
        $categoria = '';
    }
    if ($q === '' && $categoria === '') {
        $errores[] = 'Ingresá un término de búsqueda o elegí una categoría.';
    } elseif ($q !== '' && mb_strlen($q) < 2) {
        $errores[] = 'El término de búsqueda debe tener al menos 2 caracteres.';
    } elseif (mb_strlen($q) > 60) {
        $errores[] = 'El término de búsqueda no puede superar los 60 caracteres.';
    }

    if (!$errores) {
        foreach (catalogo() as $item) {
            if ($categoria !== '' && $item['seccion'] !== $categoria) {
                continue;
            }
            if ($q !== '' && mb_stripos($item['titulo'] . ' ' . $item['descripcion'], $q) === false) {
                continue;
            }
            $resultados[] = $item;
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<main id="contenido">
<section id="buscar" class="page-top">
<div class="container">
<h2 class="section-title">Buscar en el catálogo</h2>
<p class="page-intro">Encontrá cursos, eventos y productos por palabra clave o por categoría.</p>

<form class="form-buscar" method="get" action="buscar.php" role="search" aria-label="Buscador" novalidate>
<div class="campo">
<label for="q">Palabra clave</label>
<input type="search" id="q" name="q" maxlength="60" placeholder="Ej: espresso, kit, evento" value="<?= e($q) ?>">
</div>
<div class="campo">
<label for="categoria">Categoría</label>
<select id="categoria" name="categoria">
<option value="">Todas</option>
<?php foreach ($categorias as $clave => $etiqueta): ?>
<option value="<?= e($clave) ?>"<?= $categoria === $clave ? ' selected' : '' ?>><?= e($etiqueta) ?></option>
<?php endforeach; ?>
</select>
</div>
<button class="btn" type="submit">Buscar</button>
</form>

<?php if ($errores): ?>
<div class="alert alert-error" role="alert" style="margin-top:25px;">
<ul>
<?php foreach ($errores as $mensaje_error): ?>
<li><?= e($mensaje_error) ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php elseif ($enviado): ?>
<p class="resultados-info" role="status">
<?= count($resultados) ?> resultado(s)
<?php if ($q !== ''): ?> para “<?= e($q) ?>”<?php endif; ?>
<?php if ($categoria !== ''): ?> en <?= e($categorias[$categoria]) ?><?php endif; ?>
</p>
<?php if ($resultados): ?>
<div class="cards">
<?php foreach ($resultados as $item) { render_card($item, $ruta_base, true); } ?>
</div>
<?php else: ?>
<div class="alert alert-error" role="status">No encontramos resultados. Probá con otra palabra o con otra categoría.</div>
<?php endif; ?>
<?php endif; ?>
</div>
</section>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
