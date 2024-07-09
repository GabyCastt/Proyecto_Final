-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2024 a las 07:56:30
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--
CREATE DATABASE proyecto_final;
CREATE TABLE `amigos` (
  `id_amigo` int(11) NOT NULL,
  `id_usuario1` int(11) DEFAULT NULL,
  `id_usuario2` int(11) DEFAULT NULL,
  `fecha_amistad` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`id_amigo`, `id_usuario1`, `id_usuario2`, `fecha_amistad`) VALUES
(1, 1, 2, '2024-07-09 06:28:13'),
(2, 4, 2, '2024-07-09 06:29:21'),
(3, 3, 1, '2024-07-09 06:29:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_publicacion` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `contenido` text NOT NULL,
  `fecha_comentario` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `nombre_grupo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `nombre_grupo`, `descripcion`) VALUES
(1, 'Grupo1', 'Pruebas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros_grupo`
--

CREATE TABLE `miembros_grupo` (
  `id_miembro` int(11) NOT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_union` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `miembros_grupo`
--

INSERT INTO `miembros_grupo` (`id_miembro`, `id_grupo`, `id_usuario`, `fecha_union`) VALUES
(1, 1, 4, '2024-07-09 06:32:26');

-- Tabla Publicaciones
CREATE TABLE Publicaciones (
    id_publicacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    titulo VARCHAR(100) NOT NULL,
    contenido TEXT NOT NULL,
    fecha_publicacion DATETIME NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Tabla Comentarios
CREATE TABLE Comentarios (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    id_publicacion INT,
    id_usuario INT,
    contenido TEXT NOT NULL,
    fecha_comentario DATETIME NOT NULL,
    FOREIGN KEY (id_publicacion) REFERENCES Publicaciones(id_publicacion),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Tabla Reacciones
CREATE TABLE Reacciones (
    id_reaccion INT AUTO_INCREMENT PRIMARY KEY,
    id_comentario INT,
    id_usuario INT,
    tipo_reaccion VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_comentario) REFERENCES Comentarios(id_comentario),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Tabla Amigos (auto-relación)
CREATE TABLE Amigos (
    id_amigo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario1 INT,
    id_usuario2 INT,
    fecha_amistad DATETIME NOT NULL,
    FOREIGN KEY (id_usuario1) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_usuario2) REFERENCES Usuarios(id_usuario)
);

-- Tabla Grupos
CREATE TABLE Grupos (
    id_grupo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_grupo VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Tabla Miembros_Grupo (relación N:M entre Grupos y Usuarios)
CREATE TABLE Miembros_Grupo (
    id_miembro INT AUTO_INCREMENT PRIMARY KEY,
    id_grupo INT,
    id_usuario INT,
    fecha_union DATETIME NOT NULL,
    FOREIGN KEY (id_grupo) REFERENCES Grupos(id_grupo),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);CREATE DATABASE ejercicio_calvache_castillo;

USE ejercicio_calvache_castillo;

-- Tabla Usuarios
CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    correo_electronico VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
);

-- Tabla Publicaciones
CREATE TABLE Publicaciones (
    id_publicacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    titulo VARCHAR(100) NOT NULL,
    contenido TEXT NOT NULL,
    fecha_publicacion DATETIME NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Tabla Comentarios
CREATE TABLE Comentarios (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    id_publicacion INT,
    id_usuario INT,
    contenido TEXT NOT NULL,
    fecha_comentario DATETIME NOT NULL,
    FOREIGN KEY (id_publicacion) REFERENCES Publicaciones(id_publicacion),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Tabla Reacciones
CREATE TABLE Reacciones (
    id_reaccion INT AUTO_INCREMENT PRIMARY KEY,
    id_comentario INT,
    id_usuario INT,
    tipo_reaccion VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_comentario) REFERENCES Comentarios(id_comentario),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- Tabla Amigos (auto-relación)
CREATE TABLE Amigos (
    id_amigo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario1 INT,
    id_usuario2 INT,
    fecha_amistad DATETIME NOT NULL,
    FOREIGN KEY (id_usuario1) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_usuario2) REFERENCES Usuarios(id_usuario)
);

-- Tabla Grupos
CREATE TABLE Grupos (
    id_grupo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_grupo VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Tabla Miembros_Grupo (relación N:M entre Grupos y Usuarios)
CREATE TABLE Miembros_Grupo (
    id_miembro INT AUTO_INCREMENT PRIMARY KEY,
    id_grupo INT,
    id_usuario INT,
    fecha_union DATETIME NOT NULL,
    FOREIGN KEY (id_grupo) REFERENCES Grupos(id_grupo),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);