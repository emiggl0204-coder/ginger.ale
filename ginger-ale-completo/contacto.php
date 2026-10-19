<?php
$titulo_pagina = "Contacto | Ginger Ale";
$config = require __DIR__ . '/config/env.php';

// Variables para persistencia y mensajes
$errores = [];
$exito = false;
$nombre = '';
$email = '';
$curso = '';
$mensaje = '';

// Prellenar curso desde GET (ej: ?curso=barista)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['curso'])) {
    $curso = htmlspecialchars(trim($_GET['curso']), ENT_QUOTES, 'UTF-8');
}

// Procesamiento POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitización estricta
    $nombre  = isset($_POST['nombre'])  ? trim($_POST['nombre'])  : '';
    $email   = isset($_POST['email'])   ? trim($_POST['email'])   : '';
    $curso   = isset($_POST['curso'])   ? trim($_POST['curso'])   : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones servidor
    if ($nombre === '') {
        $errores['nombre'] = 'Por favor ingresá tu nombre completo.';
    } elseif (mb_strlen($nombre) < 3) {
        $errores['nombre'] = 'El nombre debe tener al menos 3 caracteres.';
    }

    if ($email === '') {
        $errores['email'] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Ingresá un correo válido (ej: usuario@dominio.com).';
    }

    if ($curso === '') {
        $errores['curso'] = 'Seleccioná un curso de interés.';
    }

    if ($mensaje === '') {
        $errores['mensaje'] = 'Escribí un mensaje o consulta.';
    } elseif (mb_strlen($mensaje) < 10) {
        $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
    }

    // Si no hay errores → éxito (en un proyecto real se enviaría email o se guardaría en BD)
    if (empty($errores)) {
        $exito = true;
        // Aquí se podría: mail(), o INSERT en base de datos
        // Por ahora solo mostramos feedback
        // Limpiamos campos después del éxito
        $nombre = $email = $curso = $mensaje = '';
    }
}

// Mapa de cursos para mostrar texto legible
$opciones_curso = [
    'barista'   => 'Barista Profesional',
    'bartender' => 'Bartender Profesional',
    'intensivo' => 'Curso Intensivo',
    'virtual'   => 'Cursos Virtuales',
    'eventos'   => 'Barra Móvil y Eventos',
];

require_once 'includes/header.php';
?>

<section style="padding-top:100px;">
<div class="container">
<h2 class="section-title">Contacto</h2>

<?php if ($exito): ?>
<div class="alert-exito">
    <strong>¡Consulta enviada correctamente!</strong><br>
    Gracias por contactarte con <?= htmlspecialchars($config['APP_NAME'], ENT_QUOTES, 'UTF-8') ?>. 
    Te responderemos a la brevedad a tu correo.
</div>
<?php endif; ?>

<?php if (!empty($errores)): ?>
<div class="alert-error">
    <strong>Por favor corregí los siguientes errores:</strong>
    <ul>
        <?php foreach ($errores as $error): ?>
            <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form id="formulario" method="POST" action="contacto.php" aria-label="Formulario de contacto" novalidate>
<label for="nombre">Nombre completo</label>
<input type="text" id="nombre" name="nombre" 
       value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>" 
       placeholder="Tu nombre y apellido" required
       aria-invalid="<?= isset($errores['nombre']) ? 'true' : 'false' ?>">
<?php if (isset($errores['nombre'])): ?>
<div class="error-msg visible"><?= htmlspecialchars($errores['nombre'], ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<label for="email">Correo electrónico</label>
<input type="email" id="email" name="email" 
       value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" 
       placeholder="tu@email.com" required
       aria-invalid="<?= isset($errores['email']) ? 'true' : 'false' ?>">
<?php if (isset($errores['email'])): ?>
<div class="error-msg visible"><?= htmlspecialchars($errores['email'], ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<label for="curso">Curso de interés</label>
<select id="curso" name="curso" required>
<option value="">Seleccioná una opción</option>
<?php foreach ($opciones_curso as $valor => $texto): ?>
<option value="<?= htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') ?>" 
        <?= $curso === $valor ? 'selected' : '' ?>>
    <?= htmlspecialchars($texto, ENT_QUOTES, 'UTF-8') ?>
</option>
<?php endforeach; ?>
</select>
<?php if (isset($errores['curso'])): ?>
<div class="error-msg visible"><?= htmlspecialchars($errores['curso'], ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<label for="mensaje">Mensaje</label>
<textarea id="mensaje" name="mensaje" placeholder="Contanos qué necesitás" required><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></textarea>
<?php if (isset($errores['mensaje'])): ?>
<div class="error-msg visible"><?= htmlspecialchars($errores['mensaje'], ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<button class="btn" type="submit">Enviar consulta</button>
</form>

<nav class="socials" aria-label="Redes sociales">
<a href="<?= htmlspecialchars($config['INSTAGRAM'] ?? 'https://instagram.com', ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">Instagram</a>
<a href="<?= htmlspecialchars($config['FACEBOOK'] ?? 'https://facebook.com', ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">Facebook</a>
<a href="https://wa.me/<?= htmlspecialchars($config['WHATSAPP'] ?? '', ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">WhatsApp</a>
</nav>

<p style="text-align:center;margin-top:30px;color:#aaa;">
Email de soporte: <a href="mailto:<?= htmlspecialchars($config['SUPPORT_EMAIL'], ENT_QUOTES, 'UTF-8') ?>" style="color:#3d7bff;"><?= htmlspecialchars($config['SUPPORT_EMAIL'], ENT_QUOTES, 'UTF-8') ?></a>
</p>
</div>
</section>

<?php require_once 'includes/footer.php'; ?>
