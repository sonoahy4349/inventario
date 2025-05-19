CREATE DATABASE helpdesk;
USE helpdesk;

-- Tabla de Roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla de Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    area VARCHAR(100),
    telefono VARCHAR(20),
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

-- Tabla de Estatus de Tickets
CREATE TABLE estatus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla de Tickets
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    asignado_a INT DEFAULT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    estatus_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (asignado_a) REFERENCES usuarios(id),
    FOREIGN KEY (estatus_id) REFERENCES estatus(id)
);

-- Tabla de Interacciones en los Tickets
CREATE TABLE interacciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    usuario_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla de Equipos
CREATE TABLE equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL,
    modelo VARCHAR(100),
    numero_serie VARCHAR(100) UNIQUE,
    descripcion TEXT,
    fecha_ingreso TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Relación entre Tickets y Equipos
CREATE TABLE ticket_equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    equipo_id INT NOT NULL,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    FOREIGN KEY (equipo_id) REFERENCES equipos(id)
);

-- Tabla de Reportes
CREATE TABLE reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    generado_por INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    FOREIGN KEY (generado_por) REFERENCES usuarios(id)
);

-- Tabla de Configuraciones Dinámicas
CREATE TABLE configuraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT NOT NULL
);

---------------------------------------------------------- 


CREATE TABLE estados_equipo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);


INSERT INTO estados_equipo (nombre, descripcion) VALUES 
('Disponible', 'Equipo disponible para asignación'),
('En uso', 'Equipo asignado y en uso por un usuario'),
('En mantenimiento', 'Equipo en proceso de mantenimiento o reparación'),
('Dado de baja', 'Equipo fuera de servicio permanentemente'),
('En préstamo', 'Equipo prestado temporalmente');


ALTER TABLE equipos 
    ADD COLUMN marca VARCHAR(100) AFTER tipo,
    ADD COLUMN estado_id INT NOT NULL AFTER numero_serie,
    ADD CONSTRAINT fk_equipo_estado FOREIGN KEY (estado_id) REFERENCES estados_equipo(id);


ALTER TABLE equipos 
    CHANGE COLUMN tipo tipo VARCHAR(50) COMMENT 'Tipo de equipo (PC, laptop, impresora, etc.)';

INSERT INTO equipos (tipo, marca, modelo, numero_serie, estado_id, descripcion) 
VALUES ('Laptop', 'Dell', 'Latitude 5420', 'SN123456789', 2, 'Equipo nuevo para área de desarrollo');

CREATE TABLE ubicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    edificio VARCHAR(100) NOT NULL,
    planta INT NOT NULL,
    servicio VARCHAR(100),
    ubicacion_interna VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);