<?php
/**
 * Carga de variables de entorno desde el archivo .env (raíz del proyecto).
 * Si .env no existe (por ejemplo, recién clonado el repo), usa .env.example
 * como valores por defecto para que el sitio igual se pueda abrir.
 */
declare(strict_types=1);

if (!defined('APP_NAME')) {
    $raiz    = dirname(__DIR__);
    $archivo = is_file($raiz . '/.env') ? $raiz . '/.env' : $raiz . '/.env.example';

    $vars = [
        'APP_NAME'        => 'Ginger Ale',
        'APP_DESCRIPTION' => 'Escuela de Coctelería y Barismo',
        'APP_EMAIL'       => 'contacto@example.com',
        'APP_ENV'         => 'local',
    ];

    if (is_readable($archivo)) {
        foreach (file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
            $linea = trim($linea);
            if ($linea === '' || $linea[0] === '#' || !str_contains($linea, '=')) {
                continue;
            }
            [$clave, $valor] = explode('=', $linea, 2);
            $clave = trim($clave);
            $valor = trim($valor);
            // Quita comillas simples o dobles que envuelvan el valor
            if (strlen($valor) >= 2 && ($valor[0] === '"' || $valor[0] === "'") && $valor[-1] === $valor[0]) {
                $valor = substr($valor, 1, -1);
            }
            $vars[$clave] = $valor;
        }
    }

    define('APP_NAME', $vars['APP_NAME']);
    define('APP_DESCRIPTION', $vars['APP_DESCRIPTION']);
    define('APP_EMAIL', $vars['APP_EMAIL']);
    define('APP_ENV', $vars['APP_ENV']);

    // En local se muestran los errores; en cualquier otro entorno se ocultan.
    if (APP_ENV === 'local') {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', '0');
    }
}
