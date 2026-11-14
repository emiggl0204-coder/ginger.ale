-- =====================================================================
-- schema.sql — Esquema normalizado (3FN) del proyecto "Ginger Ale"
-- Motor: MySQL / MariaDB (XAMPP, Laragon, phpMyAdmin)
-- Ejecutar primero este archivo y luego consultas.sql
-- =====================================================================

CREATE DATABASE IF NOT EXISTS ginger_ale
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE ginger_ale;

-- ---------------------------------------------------------------------
-- Tablas maestras / secundarias
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS roles (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(30) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(60) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS estados_inscripcion (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(30) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Usuarios (autenticación + datos personales + rol)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    rol_id        INT NOT NULL,
    nombre        VARCHAR(60)  NOT NULL,
    apellido      VARCHAR(60)  NOT NULL,
    email         VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuarios_rol FOREIGN KEY (rol_id) REFERENCES roles (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Un usuario puede tener varios teléfonos (resuelve el campo multivalorado, 1FN)
CREATE TABLE IF NOT EXISTS usuario_telefonos (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    telefono   VARCHAR(25) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_telefonos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT uq_usuario_telefono UNIQUE (usuario_id, telefono)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Tabla principal de negocio: cursos
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cursos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    titulo       VARCHAR(100) NOT NULL,
    descripcion  TEXT,
    modalidad    ENUM('presencial','virtual') NOT NULL DEFAULT 'presencial',
    precio       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    activo       TINYINT(1) NOT NULL DEFAULT 1,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_cursos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Tabla de relación N:M (usuarios <-> cursos) con detalle propio
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS inscripciones (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id  INT NOT NULL,
    curso_id    INT NOT NULL,
    estado_id   INT NOT NULL,
    fecha_alta  DATE NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_insc_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_insc_curso FOREIGN KEY (curso_id) REFERENCES cursos (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_insc_estado FOREIGN KEY (estado_id) REFERENCES estados_inscripcion (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT uq_usuario_curso UNIQUE (usuario_id, curso_id)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Consultas recibidas desde el formulario de contacto (clase5/contacto.php)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS consultas (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    curso_id   INT NULL,
    nombre     VARCHAR(80)  NOT NULL,
    email      VARCHAR(120) NOT NULL,
    mensaje    TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_consultas_curso FOREIGN KEY (curso_id) REFERENCES cursos (id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Índices explícitos (filtrado frecuente)
-- ---------------------------------------------------------------------
-- Filtrar el catálogo por categoría y modalidad (cursos presenciales / virtuales)
CREATE INDEX idx_cursos_categoria_modalidad ON cursos (categoria_id, modalidad);
-- Buscar consultas por email del remitente
CREATE INDEX idx_consultas_email ON consultas (email);
-- Listar inscripciones por estado (pendientes, confirmadas...)
CREATE INDEX idx_inscripciones_estado ON inscripciones (estado_id);
