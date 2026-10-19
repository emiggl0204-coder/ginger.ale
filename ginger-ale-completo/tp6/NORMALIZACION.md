# Normalización – Proyecto Ginger Ale (Escuela de Coctelería y Barismo)

## Parte 1: Entidad sin normalizar

### Tabla hipotética sin normalizar: `consultas_antiguas`

| id | nombre_cliente | email | telefono | curso_interes | productos_interes | fecha_consulta | estado | profesor_asignado | telefono_profesor |
|----|----------------|-------|----------|---------------|-------------------|----------------|--------|-------------------|-------------------|
| 1  | Ana López     | ana@mail.com | 11-5555-1111, 11-5555-2222 | Barista Profesional, Curso Intensivo | Kit Bartender, Cafetera | 2026-09-15 | pendiente | Juan Pérez | 11-4444-3333 |
| 2  | Carlos Ruiz   | carlos@mail.com | 11-6666-7777 | Bartender Profesional | - | 2026-09-20 | contactado | María Gómez | 11-4444-5555 |

**Problemas observados:**
- Campos multivaluados: `telefono`, `curso_interes`, `productos_interes`
- Redundancia: datos del profesor repetidos en cada consulta
- Violación de atomicidad

---

## Proceso de Normalización

### 1FN – Primera Forma Normal (atomicidad)

Se eliminan los grupos repetitivos. Cada valor atómico en su propia fila o tabla de detalle.

**Tablas resultantes en 1FN:**

**clientes**
| id_cliente | nombre | email |
|------------|--------|-------|
| 1 | Ana López | ana@mail.com |
| 2 | Carlos Ruiz | carlos@mail.com |

**telefonos_cliente**
| id_telefono | id_cliente | telefono |
|-------------|------------|----------|
| 1 | 1 | 11-5555-1111 |
| 2 | 1 | 11-5555-2222 |
| 3 | 2 | 11-6666-7777 |

**consultas**
| id_consulta | id_cliente | fecha_consulta | estado | id_profesor |
|-------------|------------|----------------|--------|-------------|
| 1 | 1 | 2026-09-15 | pendiente | 1 |
| 2 | 2 | 2026-09-20 | contactado | 2 |

**consulta_curso** (relación N:M)
| id_consulta | id_curso |
|-------------|----------|
| 1 | 1 |
| 1 | 3 |

**consulta_producto**
| id_consulta | id_producto |
|-------------|-------------|
| 1 | 1 |
| 1 | 2 |

### 2FN – Segunda Forma Normal

Todas las columnas no-clave dependen completamente de la clave primaria.
En las tablas de detalle (consulta_curso, consulta_producto) la clave es compuesta y no hay atributos no-clave que dependan parcialmente → ya cumple 2FN.

### 3FN – Tercera Forma Normal

Se eliminan dependencias transitivas. Los datos del profesor y de cursos/productos se extraen a tablas propias.

**profesores**
| id_profesor | nombre | email | telefono |
|-------------|--------|-------|----------|
| 1 | Juan Pérez | juan@gingerale.com | 11-4444-3333 |
| 2 | María Gómez | maria@gingerale.com | 11-4444-5555 |

**cursos**
| id_curso | nombre | tipo | descripcion | precio |
|----------|--------|------|-------------|--------|
| 1 | Barista Profesional | presencial | ... | 85000 |
| 2 | Bartender Profesional | presencial | ... | 95000 |
| 3 | Curso Intensivo | presencial | ... | 120000 |

**productos**
| id_producto | nombre | precio | stock |
|-------------|--------|--------|-------|
| 1 | Kit Bartender | 45000 | 15 |
| 2 | Cafetera Profesional | 280000 | 4 |

---

## Listado final de tablas normalizadas

| Tabla | Clave Primaria (PK) | Claves Foráneas (FK) |
|-------|---------------------|----------------------|
| roles | id_rol | - |
| usuarios | id_usuario | id_rol → roles |
| profesores | id_profesor | id_usuario → usuarios (opcional) |
| categorias_curso | id_categoria | - |
| cursos | id_curso | id_categoria → categorias_curso |
| productos | id_producto | - |
| clientes | id_cliente | - |
| telefonos_cliente | id_telefono | id_cliente → clientes |
| consultas | id_consulta | id_cliente → clientes, id_profesor → profesores |
| consulta_curso | (id_consulta, id_curso) | id_consulta → consultas, id_curso → cursos |
| consulta_producto | (id_consulta, id_producto) | id_consulta → consultas, id_producto → productos |
| inscripciones | id_inscripcion | id_cliente → clientes, id_curso → cursos |
| estados_consulta | id_estado | - |

Todas las tablas principales incluyen campos de auditoría:
`created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP`
`updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`
