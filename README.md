# Ginger Ale — Escuela de Coctelería y Barismo

Sitio web de una escuela de coctelería y barismo con cursos presenciales y virtuales, equipo docente, barra móvil para eventos, tienda de insumos, galería, buscador y formulario de contacto.

**Evolución del proyecto (Programación Web):**
- **Hito 1:** maqueta estática responsive (HTML + CSS + JS).
- **TP4 – Unidad 4:** migración a **PHP**, modularización con **Server Side Includes** (`header.php`, `nav.php`, `footer.php`), título dinámico por página, ítem activo del menú y variables de entorno `.env`.
- **TP5 – Clase 5:** formularios **POST** y **GET** con sanitización estricta (XSS), validación en servidor, mensajes y persistencia de datos.
- **TP6:** normalización, `schema.sql` y `consultas.sql` (MySQL).

## Prototipo en Figma

🔗 [PEGAR AQUÍ EL ENLACE PÚBLICO DE FIGMA]

## Tecnologías utilizadas

HTML5 · CSS3 · JavaScript (vanilla) · PHP 8.x · MySQL/MariaDB · XAMPP / Laragon · Git y GitHub

## Estructura del proyecto

```
ginger-ale/
├── config/env.php          # Lector del archivo .env (define APP_NAME, APP_EMAIL, APP_ENV...)
├── includes/
│   ├── header.php          # <head>, metadatos, <title> dinámico, CSS
│   ├── nav.php             # Cabecera + menú con ítem "active"
│   ├── footer.php          # Pie, scripts JS
│   ├── funciones.php       # e() = htmlspecialchars, limpiar(), CSRF, tarjetas
│   └── catalogo.php        # Datos de cursos / eventos / productos
├── css/  js/               # Estilos y scripts
├── index.php  cursos.php  profesores.php  eventos.php
├── productos.php  video.php  galeria.php  contacto.php (redirige)
├── clase5/                 # TP5: contacto.php (POST) y buscar.php (GET)
├── tp6/                    # schema.sql, consultas.sql, NORMALIZACION.md
├── docs/capturas/          # Capturas de pantalla del README
├── .env.example            # Plantilla de variables de entorno
└── .gitignore              # Excluye .env
```

## Instalación y ejecución local

1. Instalar **XAMPP** (o **Laragon**) con PHP 8.x.
2. Clonar el repositorio dentro de `htdocs` (XAMPP) o `www` (Laragon):
   ```bash
   cd C:/xampp/htdocs
   git clone https://github.com/<tu-usuario>/<tu-repo>.git ginger-ale
   ```
3. Crear el archivo de entorno a partir de la plantilla y completar los valores:
   ```bash
   cd ginger-ale
   cp .env.example .env
   ```
4. Iniciar **Apache** desde el panel de XAMPP/Laragon.
5. Abrir <http://localhost/ginger-ale/> en el navegador.

> Alternativa sin XAMPP: `php -S localhost:8000` dentro de la carpeta del proyecto y abrir <http://localhost:8000>.

## Variables de entorno (`.env`)

| Variable | Descripción |
|---|---|
| `APP_NAME` | Nombre de la empresa/aplicación (se muestra en título, logo y pie) |
| `APP_DESCRIPTION` | Descripción corta del sitio |
| `APP_EMAIL` | Email de contacto/soporte |
| `APP_ENV` | Entorno de ejecución (`local` muestra errores PHP) |

`.env` está en `.gitignore`; el repositorio incluye `.env.example` como plantilla.

## Evidencia de funcionamiento — TP4

- **Servidor local ejecutándose** (`http://localhost/...`):
  ![Servidor local](docs/capturas/01-servidor-local.png)
- **Estructura modular (SSI)** — `header.php`, `nav.php`, `footer.php`:
  ![Estructura modular](docs/capturas/02-estructura-ssi.png)
- **Navegación dinámica** — título de pestaña y clase `active` en el menú:
  ![Navegación dinámica](docs/capturas/03-navegacion-dinamica.png)
- **Variables de entorno** — `.env.example` en el repositorio:
  ![.env.example](docs/capturas/04-env-example.png)

## Clase 5 — Formularios POST y GET (carpeta `clase5/`)

### Formulario de contacto — método POST (`clase5/contacto.php`)
- Campos: nombre, email, curso de interés (select) y mensaje.
- **Sanitización:** `filter_input()` + `limpiar()` (trim y eliminación de caracteres de control); el email pasa por `FILTER_SANITIZE_EMAIL`. Toda salida se imprime con `e()` (`htmlspecialchars` con `ENT_QUOTES`), por lo que `<script>` se muestra como texto y no se ejecuta.
- **Validación en servidor:** campos requeridos, largo mínimo/máximo, formato de nombre, `FILTER_VALIDATE_EMAIL` y lista blanca para el curso.
- **Seguridad extra:** token CSRF de sesión.
- **Feedback:** mensaje de éxito con resumen de la consulta, o lista de errores con aviso junto a cada campo.
- **Persistencia:** ante un error se conservan los datos ingresados.

### Buscador — método GET (`clase5/buscar.php`)
- Parámetros `q` (palabra clave) y `categoria` (lista blanca de secciones).
- Filtra el catálogo (`includes/catalogo.php`) y muestra la cantidad de resultados; valida términos vacíos, demasiado cortos o largos y categorías inválidas. Conserva lo escrito en el formulario.

### Capturas
- Formulario con errores de validación y datos conservados: ![POST errores](docs/capturas/05-post-errores.png)
- Envío exitoso: ![POST ok](docs/capturas/06-post-exito.png)
- Intento de XSS mostrado como texto: ![XSS](docs/capturas/07-xss-escapado.png)
- Buscador con resultados: ![GET resultados](docs/capturas/08-get-resultados.png)
- Buscador con error de validación: ![GET error](docs/capturas/09-get-error.png)

## TP6 — Base de datos (carpeta `tp6/`)

- [`NORMALIZACION.md`](tp6/NORMALIZACION.md): registro sin normalizar, 1FN, 2FN, 3FN y listado de tablas con PK/FK.
- [`schema.sql`](tp6/schema.sql): creación de la base `ginger_ale`, 8 tablas con claves foráneas, campos de auditoría e índices.
- [`consultas.sql`](tp6/consultas.sql): pruebas CRUD (INSERT, SELECT con WHERE/ORDER BY/INNER JOIN, UPDATE y DELETE).

Ejecución: en phpMyAdmin → pestaña **SQL** → pegar y ejecutar primero `schema.sql` y después `consultas.sql`.

## Flujo de trabajo con Git

```bash
git checkout -b feature/migracion-php-ssi
git add .
git commit -m "feat: migra maquetado html a php e implementa header/nav/footer con includes"
```
Luego abrir un Pull Request hacia `main`.

## Autor

Proyecto individual — Programación Web.
