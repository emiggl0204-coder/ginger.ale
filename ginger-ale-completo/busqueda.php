<?php
$titulo_pagina = "Buscar | Ginger Ale";
$config = require __DIR__ . '/config/env.php';

$resultados = [];
$termino = '';
$filtro = '';
$mensaje_busqueda = '';

// Procesamiento GET (búsqueda / filtros)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['q']) || isset($_GET['filtro']))) {
    // Sanitización estricta
    $termino = isset($_GET['q']) ? trim($_GET['q']) : '';
    $filtro  = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';

    // Validación básica
    if ($termino !== '' && mb_strlen($termino) < 2) {
        $mensaje_busqueda = 'Escribí al menos 2 caracteres para buscar.';
    } else {
        // Simulación de datos (en un proyecto real vendría de la base de datos)
        $cursos_disponibles = [
            ['nombre' => 'Barista Profesional', 'tipo' => 'presencial', 'descripcion' => 'Espresso, latte art, molienda y extracción.'],
            ['nombre' => 'Bartender Profesional', 'tipo' => 'presencial', 'descripcion' => 'Coctelería clásica, moderna y flair.'],
            ['nombre' => 'Curso Intensivo', 'tipo' => 'presencial', 'descripcion' => 'Capacitación acelerada para trabajar rápido.'],
            ['nombre' => 'Barismo Online', 'tipo' => 'virtual', 'descripcion' => 'Clases grabadas y material descargable.'],
            ['nombre' => 'Coctelería Online', 'tipo' => 'virtual', 'descripcion' => 'Recetas y técnicas paso a paso.'],
            ['nombre' => 'Barra Móvil para Eventos', 'tipo' => 'servicio', 'descripcion' => 'Servicio profesional para casamientos y eventos.'],
            ['nombre' => 'Kit Bartender', 'tipo' => 'producto', 'descripcion' => 'Coctelera, medidor y accesorios profesionales.'],
            ['nombre' => 'Cafeteras Profesionales', 'tipo' => 'producto', 'descripcion' => 'Equipamiento para cafeterías y escuelas.'],
        ];

        foreach ($cursos_disponibles as $item) {
            $coincide_termino = true;
            $coincide_filtro  = true;

            if ($termino !== '') {
                $texto = mb_strtolower($item['nombre'] . ' ' . $item['descripcion']);
                $coincide_termino = (mb_strpos($texto, mb_strtolower($termino)) !== false);
            }

            if ($filtro !== '' && $filtro !== 'todos') {
                $coincide_filtro = ($item['tipo'] === $filtro);
            }

            if ($coincide_termino && $coincide_filtro) {
                $resultados[] = $item;
            }
        }

        if (empty($resultados)) {
            $mensaje_busqueda = 'No se encontraron resultados para tu búsqueda.';
        } else {
            $mensaje_busqueda = 'Se encontraron ' . count($resultados) . ' resultado(s).';
        }
    }
}

require_once 'includes/header.php';
?>

<section style="padding-top:100px;">
<div class="container">
<h2 class="section-title">Buscar cursos y productos</h2>

<form method="GET" action="busqueda.php" style="max-width:700px;margin:0 auto 40px;display:flex;flex-direction:column;gap:18px;">
<label for="q">¿Qué estás buscando?</label>
<input type="text" id="q" name="q" 
       value="<?= htmlspecialchars($termino, ENT_QUOTES, 'UTF-8') ?>" 
       placeholder="Ej: barista, cóctel, kit, evento...">

<label for="filtro">Filtrar por tipo</label>
<select id="filtro" name="filtro">
<option value="todos" <?= $filtro === 'todos' || $filtro === '' ? 'selected' : '' ?>>Todos</option>
<option value="presencial" <?= $filtro === 'presencial' ? 'selected' : '' ?>>Cursos Presenciales</option>
<option value="virtual" <?= $filtro === 'virtual' ? 'selected' : '' ?>>Cursos Virtuales</option>
<option value="servicio" <?= $filtro === 'servicio' ? 'selected' : '' ?>>Servicios / Eventos</option>
<option value="producto" <?= $filtro === 'producto' ? 'selected' : '' ?>>Productos</option>
</select>

<button class="btn" type="submit">Buscar</button>
</form>

<?php if ($mensaje_busqueda !== ''): ?>
<p style="text-align:center;color:#3d7bff;margin-bottom:25px;"><?= htmlspecialchars($mensaje_busqueda, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<?php if (!empty($resultados)): ?>
<div class="cards">
<?php foreach ($resultados as $item): ?>
<article class="card">
<div class="card-content">
<h3><?= htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8') ?></h3>
<p style="color:#aaa;font-size:0.85rem;text-transform:uppercase;margin-bottom:8px;"><?= htmlspecialchars($item['tipo'], ENT_QUOTES, 'UTF-8') ?></p>
<p><?= htmlspecialchars($item['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
<a href="contacto.php" class="btn">Consultar</a>
</div>
</article>
<?php endforeach; ?>
</div>
<?php endif; ?>

</div>
</section>

<?php require_once 'includes/footer.php'; ?>
