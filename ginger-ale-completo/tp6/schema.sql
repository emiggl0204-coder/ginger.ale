-- =====================================================
-- schema.sql - Ginger Ale Escuela de Coctelería y Barismo
-- Ejecutar en MySQL / MariaDB (XAMPP o Laragon)
-- =====================================================

CREATE DATABASE IF NOT EXISTS ginger_ale
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ginger_ale;

-- -----------------------------------------------------
-- Tabla de roles (maestra)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE,
  descripcion VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Tabla de usuarios (autenticación + datos personales)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  telefono VARCHAR(30),
  id_rol INT NOT NULL,
  activo TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_usuarios_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
) ENGINE=InnoDB;

-- Índice para búsquedas frecuentes por email
CREATE INDEX idx_usuarios_email ON usuarios(email);

-- -----------------------------------------------------
-- Categorías de cursos (maestra)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS categorias_curso (
  id_categoria INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL UNIQUE,
  descripcion VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Cursos (entidad principal de negocio)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS cursos (
  id_curso INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  slug VARCHAR(140) NOT NULL UNIQUE,
  descripcion TEXT,
  tipo ENUM('presencial','virtual','intensivo') NOT NULL DEFAULT 'presencial',
  duracion_horas INT,
  precio DECIMAL(10,2) NOT NULL DEFAULT 0,
  id_categoria INT,
  cupo_maximo INT DEFAULT 12,
  activo TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_cursos_categoria FOREIGN KEY (id_categoria) REFERENCES categorias_curso(id_categoria)
) ENGINE=InnoDB;

CREATE INDEX idx_cursos_tipo ON cursos(tipo);
CREATE INDEX idx_cursos_categoria ON cursos(id_categoria);

-- -----------------------------------------------------
-- Productos / Insumos
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS productos (
  id_producto INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  stock INT DEFAULT 0,
  activo TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Clientes / Consultas (formulario de contacto)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS clientes (
  id_cliente INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  telefono VARCHAR(30),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE INDEX idx_clientes_email ON clientes(email);

-- -----------------------------------------------------
-- Consultas recibidas desde el formulario (POST)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS consultas (
  id_consulta INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NOT NULL,
  id_curso INT NULL,                 -- curso de interés (opcional)
  mensaje TEXT NOT NULL,
  estado ENUM('pendiente','contactado','cerrado') DEFAULT 'pendiente',
  origen VARCHAR(50) DEFAULT 'web',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_consultas_cliente FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
  CONSTRAINT fk_consultas_curso FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
) ENGINE=InnoDB;

CREATE INDEX idx_consultas_estado ON consultas(estado);

-- -----------------------------------------------------
-- Inscripciones (relación cliente ↔ curso)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS inscripciones (
  id_inscripcion INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NOT NULL,
  id_curso INT NOT NULL,
  fecha_inscripcion DATE NOT NULL,
  estado ENUM('activa','cancelada','finalizada') DEFAULT 'activa',
  monto_pagado DECIMAL(10,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_inscripciones_cliente FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
  CONSTRAINT fk_inscripciones_curso FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Tabla de relación N:M (ejemplo: cursos que recomiendan productos)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS curso_producto (
  id_curso INT NOT NULL,
  id_producto INT NOT NULL,
  PRIMARY KEY (id_curso, id_producto),
  CONSTRAINT fk_cp_curso FOREIGN KEY (id_curso) REFERENCES cursos(id_curso) ON DELETE CASCADE,
  CONSTRAINT fk_cp_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
) ENGINE=InnoDB;
