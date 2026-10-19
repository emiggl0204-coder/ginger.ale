<?php
/**
 * Configuración de variables de entorno - Ginger Ale
 * En producción usar un .env real y dotenv, aquí usamos un archivo PHP seguro.
 */

// Evitar acceso directo
if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'env.php') {
    http_response_code(403);
    exit('Acceso denegado');
}

return [
    'APP_NAME'       => 'Ginger Ale',
    'APP_TAGLINE'    => 'Escuela de Coctelería y Barismo',
    'APP_ENV'        => 'local',
    'APP_URL'        => 'http://localhost/ginger-ale',
    'SUPPORT_EMAIL'  => 'contacto@gingerale.com.ar',
    'WHATSAPP'       => '54911XXXXXXXX',
    'INSTAGRAM'      => 'https://instagram.com/gingerale.escuela',
    'FACEBOOK'       => 'https://facebook.com/gingerale.escuela',
    'YEAR'           => date('Y'),
];
