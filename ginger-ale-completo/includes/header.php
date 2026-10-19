<?php
// Cargar configuración (solo una vez)
if (!isset($config) || !is_array($config)) {
    $config = require __DIR__ . '/../config/env.php';
}
$nombre_sitio = $config['APP_NAME'] ?? 'Ginger Ale';
$tagline = $config['APP_TAGLINE'] ?? 'Escuela de Coctelería y Barismo';

// Título dinámico (se define en cada página antes del include)
if (!isset($titulo_pagina)) {
    $titulo_pagina = $nombre_sitio . ' | ' . $tagline;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Escuela de Coctelería y Barismo profesional. Cursos presenciales y virtuales de barista y bartender.">
<title><?= htmlspecialchars($titulo_pagina, ENT_QUOTES, 'UTF-8') ?></title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<a class="skip-link" href="#contenido">Saltar al contenido principal</a>
<header role="banner">
<p class="logo"><span><?= htmlspecialchars($nombre_sitio, ENT_QUOTES, 'UTF-8') ?></span></p>
<?php require_once __DIR__ . '/nav.php'; ?>
</header>
<main id="contenido">
