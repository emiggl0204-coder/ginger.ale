# Ginger Ale – Escuela de Coctelería y Barismo

Sitio web de la escuela de coctelería y barismo **Ginger Ale**.  
Proyecto integrador de la asignatura **Programación Web**.

## Descripción

Aplicación web migrada de maqueta estática HTML a arquitectura **Server-Side Rendering (SSR)** con PHP, modularización mediante includes (SSI), variables de entorno, procesamiento de formularios (POST/GET) con sanitización XSS y esquema de base de datos normalizado.

### Refactorización realizada (Unidad 4 + Clase 5)

- Migración completa de `.html` → `.php`
- Extracción de componentes reutilizables: `header.php`, `nav.php`, `footer.php`
- Título de página dinámico (`$titulo_pagina`)
- Menú con clase `active` según la página actual
- Variables de configuración en `config/env.php` + `.env.example`
- Formulario de contacto (método **POST**) con validación y sanitización en servidor
- Módulo de búsqueda (método **GET**) con filtros y resultados
- Persistencia de datos en el formulario ante errores de validación
- Mensajes de éxito / error claros para el usuario

## Tecnologías utilizadas

- HTML5 + CSS3 (responsive)
- JavaScript (vanilla)
- PHP 8.x
- MySQL / MariaDB
- XAMPP o Laragon (entorno local)

## Estructura del proyecto

```
ginger-ale/
├── config/
│   └── env.php
├── includes/
│   ├── header.php
│   ├── nav.php
│   └── footer.php
├── css/
│   └── styles.css
├── js/
│   └── main.js
├── tp6/
│   ├── NORMALIZACION.md
│   ├── schema.sql
│   └── consultas.sql
├── index.php
├── cursos.php
├── virtuales.php
├── profesores.php
├── eventos.php
├── productos.php
├── contacto.php      ← Formulario POST + sanitización
├── busqueda.php      ← Formulario GET + filtros
├── .env.example
├── .gitignore
└── README.md
```

## Instrucciones de instalación y ejecución local

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/TU-USUARIO/ginger-ale.git
   cd ginger-ale
   ```

2. Copiar el archivo de ejemplo de entorno:
   ```bash
   cp .env.example .env
   ```
   (Editar valores reales si es necesario. El archivo `.env` está en `.gitignore`)

3. Colocar la carpeta del proyecto dentro de:
   - **XAMPP**: `C:\xampp\htdocs\ginger-ale`
   - **Laragon**: `C:\laragon\www\ginger-ale`

4. Iniciar Apache (y MySQL si vas a usar la base de datos).

5. Abrir en el navegador:
   ```
   http://localhost/ginger-ale/
   ```
   o
   ```
   http://localhost/ginger-ale/index.php
   ```

6. (Opcional) Base de datos:
   - Abrir phpMyAdmin
   - Importar `tp6/schema.sql`
   - Luego importar `tp6/consultas.sql` para datos de prueba

## Formularios implementados (Clase 5)

### 1. Contacto – Método POST (`contacto.php`)
- Campos: nombre, email, curso de interés, mensaje
- Validación en servidor: campos obligatorios, formato de email, longitud mínima
- Sanitización con `htmlspecialchars()`, `trim()` y `filter_var()`
- Persistencia de valores ingresados si hay errores
- Mensaje de éxito o listado de errores

### 2. Búsqueda – Método GET (`busqueda.php`)
- Campos: término de búsqueda + filtro por tipo (presencial / virtual / servicio / producto)
- Resultados dinámicos simulados (listos para conectar a MySQL)
- Sanitización de todos los parámetros GET

## Normalización y Base de Datos (TP6)

Ver carpeta `tp6/`:

- `NORMALIZACION.md` → proceso 1FN → 2FN → 3FN
- `schema.sql` → creación de la base `ginger_ale` + tablas + FKs + índices
- `consultas.sql` → inserts de prueba + SELECT con JOIN + UPDATE + DELETE

## Capturas de evidencia (agregar en el repo)

Recomendado subir a una carpeta `/docs` o `/screenshots`:

1. Sitio corriendo en `http://localhost/...`
2. Código de `includes/header.php`, `nav.php` y `footer.php`
3. Título dinámico en la pestaña del navegador + menú activo
4. Archivo `.env.example` visible en el repositorio
5. Formulario de contacto mostrando errores de validación
6. Formulario de contacto con mensaje de éxito
7. Búsqueda con resultados filtrados

## Autor

Proyecto académico – Programación Web  
Escuela de Coctelería y Barismo **Ginger Ale**
