<?php
/**
 * header.php — <head>, metadatos, hojas de estilo y apertura de <body>.
 * Variables esperadas (definirlas ANTES de incluir esta plantilla):
 *   $titulo_pagina  (string) título de la pestaña
 *   $pagina_activa  (string) clave del ítem activo del menú
 *   $ruta_base      (string) '' en la raíz, '../' dentro de clase5/
 */
require_once __DIR__ . '/funciones.php';

$ruta_base     = $ruta_base ?? '';
$titulo_pagina = $titulo_pagina ?? 'Inicio';
$pagina_activa = $pagina_activa ?? '';
$nombre_sitio  = APP_NAME;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= e($nombre_sitio . ' | ' . APP_DESCRIPTION) ?>">
<title><?= e($titulo_pagina) ?> | <?= e($nombre_sitio) ?></title>
<link rel="stylesheet" href="<?= e($ruta_base) ?>css/styles.css">
<link rel="stylesheet" href="<?= e($ruta_base) ?>css/componentes.css">
</head>
<body>
<a class="skip-link" href="#contenido">Saltar al contenido principal</a>
<?php require __DIR__ . '/nav.php'; ?>
