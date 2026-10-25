# Ginger Ale — Escuela de Coctelería y Barismo

Sitio web de una escuela de coctelería y barismo con cursos presenciales y virtuales, equipo docente, barra móvil para eventos, tienda de insumos, galería, buscador y formulario de contacto.

**Evolución del proyecto (Programación Web):**
- **Hito 1:** maqueta estática responsive (HTML + CSS + JS).
- **TP4 – Unidad 4:** migración a **PHP**, modularización con **Server Side Includes** (`header.php`, `nav.php`, `footer.php`), título dinámico por página, ítem activo del menú y variables de entorno `.env`.
- **TP5 – Clase 5:** formularios **POST** y **GET** con sanitización estricta (XSS), validación en servidor, mensajes al usuario y persistencia de datos.
- **TP6:** normalización, `schema.sql` y `consultas.sql` (MySQL).

## Prototipo en Figma

https://www.figma.com/design/tLyz7QYzLT9PDThEoiU3nx/PaginaWeb?node-id=0-1&t=xLdbdF9xRUNLbLg5-1

## Tecnologías utilizadas

HTML5 · CSS3 · JavaScript (vanilla) · PHP 8.x · MySQL · Laragon · HeidiSQL · Git y GitHub

## Estructura del proyecto

```
ginger.ale/
├── config/env.php          # Lector del archivo .env (define APP_NAME, APP_EMAIL, APP_ENV...)
├── includes/
│   ├── header.php          # <head>, metadatos, <title> dinámico, CSS
│   ├── nav.php             # Cabecera + menú con ítem "active"
│   ├── footer.php          # Pie de página y scripts JS
│   ├── funciones.php       # e() = htmlspecialchars, limpiar(), CSRF, tarjetas
│   └── catalogo.php        # Datos de cursos / eventos / productos
├── css/  js/               # Estilos y scripts
├── index.php  cursos.php  profesores.php  eventos.php
├── productos.php  video.php  galeria.php  contacto.php (redirige a clase5/)
├── clase5/                 # TP5: contacto.php (POST) y buscar.php (GET)
├── tp6/                    # schema.sql, consultas.sql, NORMALIZACION.md
├── docs/capturas/          # Capturas de pantalla del README
├── .env.example            # Plantilla de variables de entorno
└── .gitignore              # Excluye .env
```

## Instalación y ejecución local (Laragon)

1. Instalar **Laragon** (incluye Apache, PHP 8.x y MySQL).
2. Clonar el repositorio dentro de la carpeta `www` de Laragon:
   ```bash
   cd C:/laragon/www
   git clone https://github.com/emiggl0204-coder/ginger.ale.git
   cd ginger.ale
   ```
3. Crear el archivo de entorno a partir de la plantilla y completar los valores:
   ```bash
   cp .env.example .env
   ```
4. Abrir Laragon y presionar **Iniciar todo**.
5. Abrir en el navegador: <http://localhost/ginger.ale/>

> Alternativa sin Laragon: ejecutar `php -S localhost:8000` dentro de la carpeta del proyecto y abrir <http://localhost:8000>.

## Variables de entorno (`.env`)

| Variable | Descripción |
|---|---|
| `APP_NAME` | Nombre de la empresa/aplicación (se muestra en título, logo y pie) |
| `APP_DESCRIPTION` | Descripción corta del sitio |
| `APP_EMAIL` | Email de contacto/soporte |
| `APP_ENV` | Entorno de ejecución (`local` muestra los errores de PHP) |

El archivo `.env` está incluido en `.gitignore`; el repositorio contiene `.env.example` como plantilla.

## Evidencia de funcionamiento — TP4

**Servidor local ejecutándose** (`http://localhost/...`):

![Servidor local](docs/capturas/01-servidor-local.png)

**Estructura modular (SSI)** — `header.php`, `nav.php`, `footer.php`:

![Estructura modular](docs/capturas/02-estructura-ssi.png)

**Navegación dinámica** — título de la pestaña y clase `active` en el menú:

![Navegación dinámica](docs/capturas/03-navegacion-dinamica.png)

**Variables de entorno** — `.env.example` presente en el repositorio:

![.env.example](docs/capturas/04-env-example.png)

## Clase 5 — Formularios POST y GET (carpeta `clase5/`)

### Formulario de contacto — método POST (`clase5/contacto.php`)
- Campos: nombre, email, curso de interés (select) y mensaje.
- **Sanitización:** `filter_input()` + `limpiar()` (trim y eliminación de caracteres de control); el email pasa además por `FILTER_SANITIZE_EMAIL`. Toda salida se imprime con `e()` (`htmlspecialchars` con `ENT_QUOTES`), por lo que un `<script>` se muestra como texto y no se ejecuta.
- **Validación en servidor:** campos requeridos, largo mínimo y máximo, formato del nombre, `FILTER_VALIDATE_EMAIL` y lista blanca para el curso.
- **Seguridad adicional:** token CSRF de sesión.
- **Mensajes al usuario:** aviso de éxito con resumen de la consulta, o lista de errores con un mensaje junto a cada campo.
- **Persistencia:** si hay errores, se conservan los datos ingresados.

### Buscador — método GET (`clase5/buscar.php`)
- Parámetros `q` (palabra clave) y `categoria` (lista blanca de secciones).
- Filtra el catálogo (`includes/catalogo.php`) y muestra la cantidad de resultados.
- Valida términos vacíos, demasiado cortos o largos, y categorías inválidas. Conserva lo escrito en el formulario.

### Capturas

**Formulario con errores de validación y datos conservados:**

![POST con errores](docs/capturas/05-post-errores.png)

**Envío exitoso:**

![POST exitoso](docs/capturas/06-post-exito.png)

**Intento de XSS mostrado como texto (no se ejecuta):**

![XSS escapado](docs/capturas/07-xss-escapado.png)

**Buscador con resultados:**

![GET con resultados](docs/capturas/08-get-resultados.png)

**Buscador con error de validación:**

![GET con error](docs/capturas/09-get-error.png)

## TP6 — Base de datos (carpeta `tp6/`)

- [`NORMALIZACION.md`](tp6/NORMALIZACION.md): registro sin normalizar, 1FN, 2FN, 3FN y listado de tablas con PK/FK.
- [`schema.sql`](tp6/schema.sql): creación de la base `ginger_ale`, 8 tablas con claves foráneas, campos de auditoría e índices.
- [`consultas.sql`](tp6/consultas.sql): pruebas CRUD (INSERT, SELECT con WHERE/ORDER BY/INNER JOIN, UPDATE y DELETE).

### Ejecución en HeidiSQL (Laragon)
1. En Laragon, abrir **HeidiSQL** (usuario `root`, contraseña vacía) y conectar.
2. Abrir una pestaña de consulta (`Ctrl + T`).
3. Si la base ya existía de una prueba anterior, ejecutar `DROP DATABASE IF EXISTS ginger_ale;`.
4. **Archivo → Cargar archivo SQL…** → `tp6/schema.sql` → ejecutar con `F9`.
5. Repetir con `tp6/consultas.sql`.
6. Actualizar el árbol (`F5`) para ver la base `ginger_ale` y sus tablas.

### Capturas

**Tablas creadas en HeidiSQL:**

![Tablas en HeidiSQL](docs/capturas/10-tablas-heidisql.png)

**Consulta con INNER JOIN:**

![Consulta con INNER JOIN](docs/capturas/11-consultas-join.png)

## Flujo de trabajo con Git

El desarrollo se realizó en ramas integradas a `main` mediante Pull Request:

- `feature/migracion-php-ssi`: migración a PHP, includes, `.env`, formularios de la Clase 5 y archivos del TP6.
- `feature/documentacion-capturas`: capturas de evidencia, enlace de Figma y ajustes del README.

Los commits son atómicos y descriptivos (ejemplo: `feat: migra maquetado html a php con titulo dinamico e item activo en menu`).

## Autor

Proyecto individual — Programación Web.
