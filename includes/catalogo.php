<?php
/**
 * Catálogo de contenidos del sitio (cursos, equipo, eventos y productos).
 * Las páginas lo recorren con un foreach (renderizado del lado del servidor)
 * y el buscador (GET) filtra sobre este mismo listado.
 */
declare(strict_types=1);

function secciones_catalogo(): array
{
    return [
        'cursos'     => 'Cursos presenciales',
        'virtuales'  => 'Cursos virtuales',
        'profesores' => 'Equipo',
        'eventos'    => 'Eventos',
        'productos'  => 'Productos',
    ];
}

/** Valores permitidos del select "Curso de interés" (lista blanca). */
function opciones_curso(): array
{
    return [
        'barista'   => 'Barista Profesional',
        'bartender' => 'Bartender Profesional',
        'intensivo' => 'Curso Intensivo',
        'virtual'   => 'Cursos Virtuales',
        'eventos'   => 'Barra Móvil y Eventos',
    ];
}

/** URL (relativa a la raíz) de la página donde vive cada sección. */
function pagina_de_seccion(string $seccion): string
{
    return [
        'cursos'     => 'cursos.php#presenciales',
        'virtuales'  => 'cursos.php#virtuales',
        'profesores' => 'profesores.php',
        'eventos'    => 'eventos.php',
        'productos'  => 'productos.php',
    ][$seccion] ?? 'index.php';
}

function catalogo(): array
{
    static $items = null;
    if ($items !== null) {
        return $items;
    }
    $u = 'https://images.unsplash.com/';
    $q = '?q=80&w=1200&auto=format&fit=crop';

    $items = [
        // --- Cursos presenciales ---
        ['seccion' => 'cursos', 'titulo' => 'Barista Profesional', 'descripcion' => 'Aprendé espresso, latte art, molienda, extracción, texturizado de leche y calibración de molinos.', 'img' => $u . 'photo-1517701550927-30cf4ba1fcef' . $q, 'alt' => 'Barista preparando un café espresso en una máquina profesional', 'boton' => 'Inscribirme', 'curso' => 'barista'],
        ['seccion' => 'cursos', 'titulo' => 'Bartender Profesional', 'descripcion' => 'Coctelería clásica, moderna, mixología, flair, servicio de barra y atención al cliente.', 'img' => $u . 'photo-1470337458703-46ad1756a187' . $q, 'alt' => 'Bartender preparando un cóctel profesional detrás de una barra', 'boton' => 'Inscribirme', 'curso' => 'bartender'],
        ['seccion' => 'cursos', 'titulo' => 'Curso Intensivo', 'descripcion' => 'Capacitación acelerada para comenzar a trabajar como bartender o barista en pocas semanas.', 'img' => $u . 'photo-1445116572660-236099ec97a0' . $q, 'alt' => 'Grupo de estudiantes practicando técnicas de coctelería', 'boton' => 'Inscribirme', 'curso' => 'intensivo'],
        // --- Cursos virtuales ---
        ['seccion' => 'virtuales', 'titulo' => 'Barismo Online', 'descripcion' => 'Aprendé desde cualquier lugar mediante clases grabadas, material descargable y acompañamiento de profesores.', 'img' => $u . 'photo-1495474472287-4d71bcdd2085' . $q, 'alt' => 'Alumno realizando un curso virtual de barismo desde una computadora', 'boton' => 'Más información', 'curso' => 'virtual'],
        ['seccion' => 'virtuales', 'titulo' => 'Coctelería Online', 'descripcion' => 'Aprendé recetas, técnicas modernas, decoración y preparación paso a paso.', 'img' => $u . 'photo-1514933651103-005eec06c04b' . $q, 'alt' => 'Preparación de un cóctel durante un curso virtual', 'boton' => 'Más información', 'curso' => 'virtual'],
        // --- Equipo ---
        ['seccion' => 'profesores', 'titulo' => 'Profesionales Certificados', 'descripcion' => 'Nuestro equipo posee experiencia nacional e internacional en cafetería, coctelería, mixología y servicio gastronómico.', 'img' => $u . 'photo-1524504388940-b1c1722653e1' . $q, 'alt' => 'Profesor de coctelería enseñando técnicas profesionales'],
        ['seccion' => 'profesores', 'titulo' => 'Clases Personalizadas', 'descripcion' => 'Grupos reducidos para lograr un aprendizaje práctico, dinámico y con seguimiento permanente.', 'img' => $u . 'photo-1500648767791-00dcc994a43e' . $q, 'alt' => 'Instructor explicando técnicas de barismo'],
        // --- Eventos ---
        ['seccion' => 'eventos', 'titulo' => 'Eventos Sociales y Empresariales', 'descripcion' => 'Servicio profesional para casamientos, cumpleaños, eventos corporativos y coffee break.', 'img' => $u . 'photo-1511578314322-379afb476865' . $q, 'alt' => 'Servicio de barra móvil en un evento empresarial', 'boton' => 'Solicitar Presupuesto', 'curso' => 'eventos'],
        ['seccion' => 'eventos', 'titulo' => 'Eventos Personalizados', 'descripcion' => 'Diseñamos una propuesta adaptada a cada cliente, incluyendo tragos exclusivos y decoración temática.', 'img' => $u . 'photo-1461023058943-07fcbe16d735' . $q, 'alt' => 'Bartender preparando bebidas durante un evento', 'boton' => 'Consultar', 'curso' => 'eventos'],
        // --- Productos ---
        ['seccion' => 'productos', 'titulo' => 'Kit Bartender', 'descripcion' => 'Coctelera, medidor, cuchara imperial, colador y accesorios profesionales.', 'img' => $u . 'photo-1578662996442-48f60103fc96' . $q, 'alt' => 'Kit profesional para bartender con coctelera y accesorios', 'boton' => 'Comprar'],
        ['seccion' => 'productos', 'titulo' => 'Cafeteras', 'descripcion' => 'Equipamiento profesional para cafeterías, escuelas y entrenamiento.', 'img' => $u . 'photo-1511920170033-f8396924c348' . $q, 'alt' => 'Máquina de café profesional para entrenamiento de baristas', 'boton' => 'Comprar'],
        ['seccion' => 'productos', 'titulo' => 'Accesorios', 'descripcion' => 'Jarras, tamper, molinos, vasos medidores y herramientas profesionales.', 'img' => $u . 'photo-1509042239860-f550ce710b93' . $q, 'alt' => 'Accesorios para preparación de café y barismo', 'boton' => 'Comprar'],
    ];
    return $items;
}

function items_de(string $seccion): array
{
    return array_values(array_filter(catalogo(), static fn(array $i): bool => $i['seccion'] === $seccion));
}
