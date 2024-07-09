CREATE DATABASE proyecto_final;

USE proyecto_final;
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