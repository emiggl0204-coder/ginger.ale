-- =====================================================
-- consultas.sql - Datos de prueba y operaciones CRUD
-- Ginger Ale - Ejecutar después de schema.sql
-- =====================================================

USE ginger_ale;

-- =====================================================
-- 1. CREATE (Insertar datos iniciales)
-- =====================================================

-- Roles
INSERT INTO roles (nombre, descripcion) VALUES
('admin', 'Administrador del sistema'),
('profesor', 'Docente de la escuela'),
('alumno', 'Estudiante inscripto');

-- Categorías
INSERT INTO categorias_curso (nombre, descripcion) VALUES
('Barismo', 'Cursos de café y barista'),
('Coctelería', 'Cursos de bartender y mixología'),
('Eventos', 'Servicios de barra móvil');

-- Cursos
INSERT INTO cursos (nombre, slug, descripcion, tipo, duracion_horas, precio, id_categoria, cupo_maximo) VALUES
('Barista Profesional', 'barista-profesional', 'Espresso, latte art, molienda, extracción y calibración de molinos.', 'presencial', 24, 85000.00, 1, 10),
('Bartender Profesional', 'bartender-profesional', 'Coctelería clásica, moderna, mixología, flair y servicio de barra.', 'presencial', 30, 95000.00, 2, 12),
('Curso Intensivo', 'curso-intensivo', 'Capacitación acelerada para comenzar a trabajar en pocas semanas.', 'intensivo', 16, 120000.00, 2, 8),
('Barismo Online', 'barismo-online', 'Clases grabadas, material descargable y acompañamiento de profesores.', 'virtual', 20, 55000.00, 1, 50);

-- Productos
INSERT INTO productos (nombre, descripcion, precio, stock) VALUES
('Kit Bartender', 'Coctelera, medidor, cuchara imperial, colador y accesorios.', 45000.00, 15),
('Cafetera Profesional', 'Máquina espresso para entrenamiento y cafeterías.', 280000.00, 4),
('Set Accesorios Café', 'Jarras, tamper, molinos y vasos medidores.', 32000.00, 20);

-- Clientes
INSERT INTO clientes (nombre, email, telefono) VALUES
('Ana López', 'ana.lopez@email.com', '11-5555-1111'),
('Carlos Ruiz', 'carlos.ruiz@email.com', '11-6666-7777'),
('María Fernández', 'maria.f@email.com', '11-7777-8888');

-- Consultas
INSERT INTO consultas (id_cliente, id_curso, mensaje, estado) VALUES
(1, 1, 'Hola, quiero información sobre fechas del curso de Barista Profesional.', 'pendiente'),
(2, 2, 'Me interesa el curso de Bartender. ¿Hay vacantes para octubre?', 'contactado');

-- Inscripciones
INSERT INTO inscripciones (id_cliente, id_curso, fecha_inscripcion, estado, monto_pagado) VALUES
(1, 1, '2026-09-20', 'activa', 42500.00),
(3, 2, '2026-09-25', 'activa', 95000.00);

-- Relación curso-producto
INSERT INTO curso_producto (id_curso, id_producto) VALUES
(1, 2),
(1, 3),
(2, 1);

-- =====================================================
-- 2. READ (Consultas y uniones)
-- =====================================================

-- Filtrar cursos presenciales ordenados por precio
SELECT id_curso, nombre, tipo, precio
FROM cursos
WHERE tipo = 'presencial' AND activo = 1
ORDER BY precio ASC;

-- INNER JOIN: consultas con nombre del cliente y del curso
SELECT 
  c.id_consulta,
  cl.nombre AS cliente,
  cl.email,
  cu.nombre AS curso_interes,
  c.mensaje,
  c.estado,
  c.created_at
FROM consultas c
INNER JOIN clientes cl ON c.id_cliente = cl.id_cliente
LEFT JOIN cursos cu ON c.id_curso = cu.id_curso
ORDER BY c.created_at DESC;

-- =====================================================
-- 3. UPDATE
-- =====================================================

-- Cambiar estado de una consulta
UPDATE consultas
SET estado = 'cerrado'
WHERE id_consulta = 2;

-- Actualizar precio de un producto
UPDATE productos
SET precio = 42900.00
WHERE id_producto = 1;

-- =====================================================
-- 4. DELETE
-- =====================================================

-- Eliminar una relación de prueba (no borra el curso ni el producto)
DELETE FROM curso_producto
WHERE id_curso = 2 AND id_producto = 1;

-- (Opcional) Dar de baja lógica un curso
-- UPDATE cursos SET activo = 0 WHERE id_curso = 4;
