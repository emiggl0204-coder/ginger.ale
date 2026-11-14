<?php
/**
 * Funciones auxiliares compartidas: escape, limpieza de entradas, CSRF y tarjetas.
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/catalogo.php';

/** Escapa un valor para imprimirlo en HTML (previene XSS). */
function e(?string $valor): string
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Sanitiza una entrada de usuario: acepta solo strings, elimina caracteres de
 * control (conserva saltos de línea) y recorta espacios. Se usa junto con
 * filter_input() sobre $_POST / $_GET. Al imprimir siempre se usa e().
 */
function limpiar(mixed $valor): string
{
    if (!is_string($valor)) {
        return '';
    }
    $valor = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $valor) ?? '';
    return trim($valor);
}

function iniciar_sesion(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax']);
    }
}

/** Token CSRF de sesión para el formulario POST. */
function csrf_token(): string
{
    iniciar_sesion();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_valido(string $token): bool
{
    iniciar_sesion();
    return $token !== '' && isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function csrf_renovar(): void
{
    iniciar_sesion();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/** Imprime una tarjeta (card) del catálogo. */
function render_card(array $it, string $base = '', bool $etiqueta = false): void
{
    $href = null;
    if (!empty($it['boton']) && !empty($it['curso'])) {
        $href = $base . 'clase5/contacto.php?curso=' . rawurlencode($it['curso']);
    }
    echo '<article class="card">';
    echo '<img src="' . e($it['img']) . '" alt="' . e($it['alt']) . '" loading="lazy">';
    echo '<div class="card-content">';
    if ($etiqueta) {
        echo '<span class="etiqueta">' . e(secciones_catalogo()[$it['seccion']] ?? '') . '</span>';
    }
    echo '<h3>' . e($it['titulo']) . '</h3><p>' . e($it['descripcion']) . '</p>';
    if ($href !== null) {
        echo '<a class="btn" href="' . e($href) . '">' . e($it['boton']) . '</a>';
    } elseif (!empty($it['boton'])) {
        echo '<button class="btn" type="button" data-accion="comprar">' . e($it['boton']) . '</button>';
    }
    echo '</div></article>';
}
