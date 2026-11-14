<?php
/**
 * Clase 5 — Formulario de contacto (método POST).
 * - Sanitización: filter_input() + limpiar() (trim y caracteres de control) y e() = htmlspecialchars() al imprimir.
 * - Validación en servidor: campos requeridos, formato de email, lista blanca del select, largos.
 * - Persistencia: si hay errores, se conservan los datos ingresados.
 * - Protección CSRF con token de sesión.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/funciones.php';
iniciar_sesion();

$ruta_base     = '../';
$titulo_pagina = 'Contacto';
$pagina_activa = 'contacto';

$cursos  = opciones_curso();
$datos   = ['nombre' => '', 'email' => '', 'curso' => '', 'mensaje' => ''];
$errores = [];
$exito   = false;
$resumen = [];

// Preselección opcional del curso desde un enlace (?curso=barista), validada contra la lista blanca.
$pre = limpiar(filter_input(INPUT_GET, 'curso', FILTER_UNSAFE_RAW));
if (isset($cursos[$pre])) {
    $datos['curso'] = $pre;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Sanitizar entradas
    $datos['nombre']  = limpiar(filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW));
    $datos['email']   = limpiar(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $datos['curso']   = limpiar(filter_input(INPUT_POST, 'curso', FILTER_UNSAFE_RAW));
    $datos['mensaje'] = limpiar(filter_input(INPUT_POST, 'mensaje', FILTER_UNSAFE_RAW));
    $token            = limpiar(filter_input(INPUT_POST, 'csrf_token', FILTER_UNSAFE_RAW));

    // 2) Validar en el servidor
    if (!csrf_valido($token)) {
        $errores['general'] = 'La sesión del formulario venció. Recargá la página e intentá nuevamente.';
    }

    if ($datos['nombre'] === '') {
        $errores['nombre'] = 'Por favor ingresá tu nombre.';
    } elseif (mb_strlen($datos['nombre']) < 3 || mb_strlen($datos['nombre']) > 80) {
        $errores['nombre'] = 'El nombre debe tener entre 3 y 80 caracteres.';
    } elseif (!preg_match("/^[\p{L}\p{M}\s'.-]+$/u", $datos['nombre'])) {
        $errores['nombre'] = 'El nombre solo puede contener letras, espacios, apóstrofes, puntos y guiones.';
    }

    if ($datos['email'] === '') {
        $errores['email'] = 'Por favor ingresá tu correo electrónico.';
    } elseif (mb_strlen($datos['email']) > 120 || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Ingresá un correo válido (ej: usuario@dominio.com).';
    }

    if ($datos['curso'] === '') {
        $errores['curso'] = 'Seleccioná un curso de interés.';
    } elseif (!isset($cursos[$datos['curso']])) {
        $errores['curso'] = 'La opción elegida no es válida.';
    }

    if ($datos['mensaje'] === '') {
        $errores['mensaje'] = 'Contanos qué necesitás.';
    } elseif (mb_strlen($datos['mensaje']) < 10) {
        $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
    } elseif (mb_strlen($datos['mensaje']) > 1000) {
        $errores['mensaje'] = 'El mensaje no puede superar los 1000 caracteres.';
    }

    // 3) Resultado
    if (!$errores) {
        $exito   = true;
        $resumen = $datos;               // se muestra escapado con e()
        $datos   = ['nombre' => '', 'email' => '', 'curso' => '', 'mensaje' => ''];
        csrf_renovar();
        // Aquí iría el envío real (mail() o guardado en base de datos en la próxima etapa).
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<main id="contenido">
<section id="contacto" class="page-top">
<div class="container">
<h2 class="section-title">Contacto</h2>
<p class="page-intro">Escribinos y te respondemos a la brevedad. También podés escribir a <a href="mailto:<?= e(APP_EMAIL) ?>"><?= e(APP_EMAIL) ?></a>.</p>

<?php if ($exito): ?>
<div class="alert alert-ok" role="status">
<strong>¡Gracias por contactarte con <?= e($nombre_sitio) ?>!</strong> Tu consulta fue enviada correctamente.
</div>
<div class="resumen-datos">
<h3 style="color:#3d7bff;">Resumen de tu consulta</h3>
<p><strong>Nombre:</strong> <?= e($resumen['nombre']) ?></p>
<p><strong>Email:</strong> <?= e($resumen['email']) ?></p>
<p><strong>Curso de interés:</strong> <?= e($cursos[$resumen['curso']]) ?></p>
<p><strong>Mensaje:</strong> <?= nl2br(e($resumen['mensaje'])) ?></p>
</div>
<?php elseif ($errores): ?>
<div class="alert alert-error" role="alert">
<strong>No pudimos enviar tu consulta.</strong> Revisá los campos marcados:
<ul>
<?php foreach ($errores as $mensaje_error): ?>
<li><?= e($mensaje_error) ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>

<form id="formulario" method="post" action="contacto.php" aria-label="Formulario de contacto" novalidate>
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

<div>
<label for="nombre">Nombre completo</label>
<input type="text" id="nombre" name="nombre" maxlength="80" placeholder="Tu nombre y apellido" value="<?= e($datos['nombre']) ?>" class="<?= isset($errores['nombre']) ? 'campo-invalido' : '' ?>" required>
<?php if (isset($errores['nombre'])): ?><div class="error-msg visible"><?= e($errores['nombre']) ?></div><?php endif; ?>
</div>

<div>
<label for="email">Correo electrónico</label>
<input type="email" id="email" name="email" maxlength="120" placeholder="tu@email.com" value="<?= e($datos['email']) ?>" class="<?= isset($errores['email']) ? 'campo-invalido' : '' ?>" required>
<?php if (isset($errores['email'])): ?><div class="error-msg visible"><?= e($errores['email']) ?></div><?php endif; ?>
</div>

<div>
<label for="curso">Curso de interés</label>
<select id="curso" name="curso" class="<?= isset($errores['curso']) ? 'campo-invalido' : '' ?>" required>
<option value="">Seleccioná una opción</option>
<?php foreach ($cursos as $valor => $etiqueta): ?>
<option value="<?= e($valor) ?>"<?= $datos['curso'] === $valor ? ' selected' : '' ?>><?= e($etiqueta) ?></option>
<?php endforeach; ?>
</select>
<?php if (isset($errores['curso'])): ?><div class="error-msg visible"><?= e($errores['curso']) ?></div><?php endif; ?>
</div>

<div>
<label for="mensaje">Mensaje</label>
<textarea id="mensaje" name="mensaje" maxlength="1000" placeholder="Contanos qué necesitás" class="<?= isset($errores['mensaje']) ? 'campo-invalido' : '' ?>" required><?= e($datos['mensaje']) ?></textarea>
<?php if (isset($errores['mensaje'])): ?><div class="error-msg visible"><?= e($errores['mensaje']) ?></div><?php endif; ?>
</div>

<button class="btn" type="submit">Enviar consulta</button>
</form>

<nav class="socials" aria-label="Redes sociales">
<a href="https://instagram.com" target="_blank" rel="noopener">Instagram</a>
<a href="https://facebook.com" target="_blank" rel="noopener">Facebook</a>
<a href="https://wa.me/" target="_blank" rel="noopener">WhatsApp</a>
</nav>
</div>
</section>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
