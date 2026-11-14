-- =====================================================================
-- consultas.sql — Pruebas CRUD sobre el esquema de "Ginger Ale"
-- Requisito: haber ejecutado antes schema.sql sobre una base vacía.
-- Contraseña de prueba de los usuarios: "password" (hash bcrypt).
-- =====================================================================
USE ginger_ale;

-- ============================ CREATE =================================
-- Tablas maestras
INSERT INTO roles (id, nombre) VALUES
    (1, 'administrador'),
    (2, 'alumno');

INSERT INTO categorias (id, nombre) VALUES
    (1, 'Barismo'),
    (2, 'Coctelería'),
    (3, 'Eventos');

INSERT INTO estados_inscripcion (id, nombre) VALUES
    (1, 'pendiente'),
    (2, 'confirmada'),
    (3, 'cancelada');

-- Usuarios (vinculados a roles) y sus teléfonos
INSERT INTO usuarios (id, rol_id, nombre, apellido, email, password_hash) VALUES
    (1, 1, 'Emiliano', 'Gómez',  'admin@gingerale.com.ar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
    (2, 2, 'Lucía',    'Pérez',  'lucia.perez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
    (3, 2, 'Martín',   'Suárez', 'martin.suarez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO usuario_telefonos (usuario_id, telefono) VALUES
    (2, '11-5555-1234'),
    (2, '11-4444-9876'),
    (3, '11-6666-2222');

-- Tabla principal: cursos (vinculados a categorías)
INSERT INTO cursos (id, categoria_id, titulo, descripcion, modalidad, precio) VALUES
    (1, 1, 'Barista Profesional',   'Espresso, latte art, molienda y calibración de molinos.', 'presencial', 85000.00),
    (2, 2, 'Bartender Profesional', 'Coctelería clásica, moderna, flair y servicio de barra.',  'presencial', 95000.00),
    (3, 1, 'Barismo Online',        'Clases grabadas y material descargable.',                  'virtual',    40000.00),
    (4, 2, 'Coctelería Online',     'Recetas y técnicas modernas paso a paso.',                 'virtual',    42000.00);

-- Relación N:M: inscripciones (usuario + curso + estado)
INSERT INTO inscripciones (usuario_id, curso_id, estado_id, fecha_alta) VALUES
    (2, 1, 2, '2026-10-01'),
    (2, 4, 1, '2026-10-10'),
    (3, 2, 1, '2026-10-12');

-- Consultas del formulario de contacto
INSERT INTO consultas (curso_id, nombre, email, mensaje) VALUES
    (2, 'Carla Díaz',  'carla.diaz@example.com', 'Hola, quisiera saber las fechas de inicio del curso de bartender.'),
    (NULL, 'Prueba Temporal', 'prueba@example.com', 'Registro de prueba que luego se elimina.');

-- ============================= READ ==================================
-- 1) WHERE + ORDER BY: cursos virtuales activos, del más caro al más barato
SELECT id, titulo, modalidad, precio
FROM cursos
WHERE modalidad = 'virtual' AND activo = 1
ORDER BY precio DESC;

-- 2) INNER JOIN (4 tablas): inscripciones con alumno, curso, categoría y estado
SELECT i.id                                   AS inscripcion,
       CONCAT(u.nombre, ' ', u.apellido)      AS alumno,
       c.titulo                               AS curso,
       cat.nombre                             AS categoria,
       e.nombre                               AS estado,
       i.fecha_alta
FROM inscripciones i
INNER JOIN usuarios u            ON u.id   = i.usuario_id
INNER JOIN cursos c              ON c.id   = i.curso_id
INNER JOIN categorias cat        ON cat.id = c.categoria_id
INNER JOIN estados_inscripcion e ON e.id   = i.estado_id
WHERE e.nombre IN ('pendiente', 'confirmada')
ORDER BY i.fecha_alta DESC;

-- 3) INNER JOIN: usuarios con su rol
SELECT u.id, u.email, r.nombre AS rol
FROM usuarios u
INNER JOIN roles r ON r.id = u.rol_id
ORDER BY r.nombre, u.apellido;

-- ============================ UPDATE =================================
-- Confirmar la inscripción pendiente número 2
UPDATE inscripciones
SET estado_id = (SELECT id FROM estados_inscripcion WHERE nombre = 'confirmada')
WHERE id = 2;

-- Actualizar el precio de un curso específico
UPDATE cursos
SET precio = 90000.00
WHERE id = 1;

-- ============================ DELETE =================================
-- Dar de baja la consulta de prueba
DELETE FROM consultas
WHERE email = 'prueba@example.com';

-- Verificación final
SELECT id, nombre, email FROM consultas;
