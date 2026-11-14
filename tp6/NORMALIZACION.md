# Parte 1 — Normalización aplicada al proyecto Ginger Ale

Sistema: sitio de una escuela de coctelería y barismo donde los **alumnos se inscriben a cursos**, y se reciben **consultas** desde el formulario de contacto.

## 1. Entidad principal sin normalizar

Un único registro "inscripción" que mezcla datos del alumno, de sus cursos y de sus teléfonos:

| id_alumno | nombre_alumno | email | rol | telefonos | cursos | categorias | precios | estado |
|---|---|---|---|---|---|---|---|---|
| 2 | Lucía Pérez | lucia.perez@example.com | alumno | 11-5555-1234, 11-4444-9876 | Barista Profesional, Coctelería Online | Barismo, Coctelería | 85000, 42000 | confirmada, pendiente |

Problemas: campos **multivalorados** (`telefonos`, `cursos`, `categorias`, `precios`, `estado`), datos **redundantes** (el nombre de la categoría y el precio se repiten en cada alumno inscripto) y riesgo de anomalías de inserción, actualización y borrado.

## 2. Proceso de normalización

### Primera Forma Normal (1FN) — valores atómicos

Se eliminan las listas: cada celda guarda un solo valor y cada combinación alumno-curso-teléfono es una fila.

| id_alumno | nombre_alumno | email | rol | telefono | curso | categoria | precio | estado |
|---|---|---|---|---|---|---|---|---|
| 2 | Lucía Pérez | lucia.perez@example.com | alumno | 11-5555-1234 | Barista Profesional | Barismo | 85000 | confirmada |
| 2 | Lucía Pérez | lucia.perez@example.com | alumno | 11-4444-9876 | Barista Profesional | Barismo | 85000 | confirmada |
| 2 | Lucía Pérez | lucia.perez@example.com | alumno | 11-5555-1234 | Coctelería Online | Coctelería | 42000 | pendiente |
| 2 | Lucía Pérez | lucia.perez@example.com | alumno | 11-4444-9876 | Coctelería Online | Coctelería | 42000 | pendiente |

Los teléfonos y los cursos son hechos independientes entre sí, por eso conviene separarlos en tablas propias (se hace en 2FN). Clave candidata en este punto: `(id_alumno, telefono, id_curso)`.

### Segunda Forma Normal (2FN) — sin dependencias parciales

Con clave compuesta `(id_alumno, telefono, id_curso)` hay dependencias parciales:

- `nombre_alumno`, `email`, `rol` dependen **solo de** `id_alumno` → tabla **usuarios**.
- `telefono` depende **solo de** `id_alumno` (es un atributo multivalorado del alumno) → tabla **usuario_telefonos**.
- `curso`, `categoria`, `precio` dependen **solo de** `id_curso` → tabla **cursos**.
- `estado` depende de la pareja `(id_alumno, id_curso)` → tabla **inscripciones** (relación N:M).

Resultado:

- `usuarios(id, nombre, apellido, email, password_hash, rol)`
- `usuario_telefonos(id, id_usuario, telefono)`
- `cursos(id, titulo, categoria, modalidad, precio)`
- `inscripciones(id, id_usuario, id_curso, estado, fecha_alta)`

### Tercera Forma Normal (3FN) — sin dependencias transitivas

- En `usuarios`: `rol` es un texto que se repite → `id_usuario → rol_id → nombre_rol`. Se extrae a **roles**.
- En `cursos`: `id_curso → categoria` (texto repetido). Se extrae a **categorias**.
- En `inscripciones`: `estado` es texto repetido. Se extrae a **estados_inscripcion**.

Además se agrega **consultas** para guardar lo que llega desde el formulario de contacto, con una FK opcional hacia `cursos`.

## 3. Listado de tablas resultante

| Tabla | PK | FK | Descripción |
|---|---|---|---|
| `roles` | `id` | — | Roles del sistema (administrador, alumno) |
| `categorias` | `id` | — | Categorías de cursos (Barismo, Coctelería, Eventos) |
| `estados_inscripcion` | `id` | — | pendiente, confirmada, cancelada |
| `usuarios` | `id` | `rol_id → roles.id` | Datos personales y autenticación (email único, hash de contraseña) |
| `usuario_telefonos` | `id` | `usuario_id → usuarios.id` | Teléfonos de cada usuario (1:N) |
| `cursos` | `id` | `categoria_id → categorias.id` | Oferta formativa (tabla principal de negocio) |
| `inscripciones` | `id` (+ `UNIQUE usuario_id, curso_id`) | `usuario_id → usuarios.id`, `curso_id → cursos.id`, `estado_id → estados_inscripcion.id` | Relación N:M usuarios–cursos |
| `consultas` | `id` | `curso_id → cursos.id` (opcional) | Mensajes del formulario de contacto |

## 4. Diagrama de relaciones

```
roles 1 ───< usuarios 1 ───< usuario_telefonos
                 │
                 └───< inscripciones >─── 1 cursos >─── 1 categorias
                            │                 │
                            │                 └───< consultas
                            └─── >1 estados_inscripcion
```

(`1 ───<` significa "uno a muchos").
