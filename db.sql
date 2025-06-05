
-----------------------------------------

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

-- Tabla de Marcas de Equipos
CREATE TABLE equipo_marca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

-- Tabla de Tipos de Equipos
CREATE TABLE equipo_tipo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Tabla de Estados del Equipo
CREATE TABLE estados_equipo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Tabla de Equipos (ahora usando tablas de catálogo para tipo, marca y estado)
CREATE TABLE equipos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_id INT NOT NULL,
    marca_id INT NOT NULL,
    modelo VARCHAR(100),
    numero_serie VARCHAR(100) UNIQUE,
    estado_id INT NOT NULL,
    descripcion TEXT,
    fecha_ingreso TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_id) REFERENCES equipo_tipo(id),
    FOREIGN KEY (marca_id) REFERENCES equipo_marca(id),
    FOREIGN KEY (estado_id) REFERENCES estados_equipo(id)
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

-- Datos de ejemplo para estados del equipo
INSERT INTO estados_equipo (nombre, descripcion) VALUES 
('Disponible', 'Equipo disponible para asignación'),
('En uso', 'Equipo asignado y en uso por un usuario'),
('En mantenimiento', 'Equipo en proceso de mantenimiento o reparación');

-- Datos de ejemplo para marcas
INSERT INTO equipo_marca (nombre) VALUES 
('Dell'), ('HP'), ('Lenovo'), ('Canon'), ('Asus');

-- Datos de ejemplo para tipos
INSERT INTO equipo_tipo (nombre, descripcion) VALUES 
('Laptop', 'Computadora portátil'),
('PC de escritorio', 'Computadora fija para oficina o casa'),
('Impresora', 'Equipo para impresión de documentos'),
('Servidor', 'Equipo destinado a servicios en red');

-- Ejemplo de inserción de un equipo
INSERT INTO equipos (tipo_id, marca_id, modelo, numero_serie, estado_id, descripcion) 
VALUES (1, 1, 'Latitude 5420', 'SN12345678', 2, 'Equipo nuevo para área de desarrollo'),
(1, 1, 'Latitude 5420', 'j', 2, 'Equipo nuevo para área de desarrollo');

INSERT INTO roles (nombre)
VALUES 
('Administrador'),
('Soporte Técnico'),
('Usuario Final');


INSERT INTO usuarios (nombre_completo, area, telefono, correo, contrasena, rol_id)
VALUES 
('Juan Pérez López', 'Soporte Técnico', '555-1234', 'admin@hospital.com', 'admin', 1),
('Ana Martínez Díaz', 'Administración', '555-5678', 'tecnico@hospital.com', 'tecnico', 2),
('Carlos Gómez Ruiz', 'Desarrollo', '555-9012', 'usuario@hospital.com', 'usuario', 3);

-- Tabla de Edificios
CREATE TABLE edificios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    numero_plantas INT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Plantas
CREATE TABLE plantas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    edificio_id INT NOT NULL,
    numero_planta INT NOT NULL,
    nombre VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (edificio_id) REFERENCES edificios(id)
);

-- Tabla de Servicios
CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Ubicaciones Internas
CREATE TABLE ubicaciones_internas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla principal de Ubicaciones (normalizada)
CREATE TABLE ubicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    edificio_id INT NOT NULL,
    planta_id INT NOT NULL,
    servicio_id INT,
    ubicacion_interna_id INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (edificio_id) REFERENCES edificios(id),
    FOREIGN KEY (planta_id) REFERENCES plantas(id),
    FOREIGN KEY (servicio_id) REFERENCES servicios(id),
    FOREIGN KEY (ubicacion_interna_id) REFERENCES ubicaciones_internas(id)
);



-- Datos de tus edificios
INSERT INTO edificios (nombre, numero_plantas) VALUES
('A1', 4),  -- PB + 3 pisos = 4 niveles
('A2', 5),  -- PB + 4 pisos = 5 niveles
('B', 2),   -- PB + 1 piso = 2 niveles
('C', 1),   -- Solo PB = 1 nivel
('D', 1),   -- Solo PB = 1 nivel
('E', 2);   -- PB + 1 piso = 2 niveles

INSERT INTO plantas (edificio_id, numero_planta, nombre) VALUES
-- Edificio A1 (PB-3)
(1, 0, 'Planta Baja'),
(1, 1, 'Piso 1'),
(1, 2, 'Piso 2'),
(1, 3, 'Piso 3'),
-- Edificio A2 (PB-4)
(2, 0, 'Planta Baja'),
(2, 1, 'Piso 1'),
(2, 2, 'Piso 2'),
(2, 3, 'Piso 3'),
(2, 4, 'Piso 4'),
-- Edificio B (PB-1)
(3, 0, 'Planta Baja'),
(3, 1, 'Piso 1'),
-- Edificio C (PB)
(4, 0, 'Planta Baja'),
-- Edificio D (PB)
(5, 0, 'Planta Baja'),
-- Edificio E (PB-1)
(6, 0, 'Planta Baja'),
(6, 1, 'Piso 1');

INSERT INTO servicios (nombre) VALUES
('Administración'),
('Recursos Humanos'),
('Contabilidad'),
('Sistemas');

INSERT INTO ubicaciones_internas (nombre) VALUES
('Oficina 101'),
('Sala de Juntas'),
('Cubículo A'),
('Recepción');

-- INSERTAR UBICACIONES DE EJEMPLO (esto faltaba)
INSERT INTO ubicaciones (edificio_id, planta_id, servicio_id, ubicacion_interna_id) VALUES
-- Algunas ubicaciones en edificio A1
(1, 1, 1, 1), -- A1, Planta Baja, Administración, Oficina 101
(1, 2, 2, 2), -- A1, Piso 1, Recursos Humanos, Sala de Juntas
(1, 3, 3, 3), -- A1, Piso 2, Contabilidad, Cubículo A
-- Algunas ubicaciones en edificio A2
(2, 5, 4, 4), -- A2, Planta Baja, Sistemas, Recepción
(2, 6, 1, 1), -- A2, Piso 1, Administración, Oficina 101
-- Ubicaciones en edificio B
(3, 11, 2, 2), -- B, Planta Baja, Recursos Humanos, Sala de Juntas
(3, 12, 3, 3), -- B, Piso 1, Contabilidad, Cubículo A
-- Ubicaciones en edificios C, D, E
(4, 13, 1, 4), -- C, Planta Baja, Administración, Recepción
(5, 14, 4, 1), -- D, Planta Baja, Sistemas, Oficina 101
(6, 15, 2, 3); -- E, Planta Baja, Recursos Humanos, Cubículo A


-- Crear tabla de cargos
CREATE TABLE cargos (
    id_cargo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cargo VARCHAR(50) NOT NULL
);

-- Crear tabla de responsables
CREATE TABLE responsable (
    id_responsable INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    id_cargo INT,
    FOREIGN KEY (id_cargo) REFERENCES cargos(id_cargo)
);

-- Insertar cargos
INSERT INTO cargos (nombre_cargo) VALUES ('Coordinador'), ('Técnico'), ('Administrador');

-- Insertar responsables
INSERT INTO responsable (nombre, apellidos, id_cargo) VALUES ('Ana', 'López', 2);

-- Tabla de Estaciones
CREATE TABLE estaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    equipo_principal_id INT NOT NULL,
    equipo_secundario_id INT DEFAULT NULL,
    ubicacion_id INT NOT NULL,
    responsable_id INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    
    FOREIGN KEY (equipo_principal_id) REFERENCES equipos(id),
    FOREIGN KEY (equipo_secundario_id) REFERENCES equipos(id),
    FOREIGN KEY (ubicacion_id) REFERENCES ubicaciones(id),
    FOREIGN KEY (responsable_id) REFERENCES responsable(id_responsable),
    
    -- Constraints para evitar duplicados
    UNIQUE KEY unique_equipo_principal (equipo_principal_id),
    UNIQUE KEY unique_equipo_secundario (equipo_secundario_id)
);

-- Insertar datos de ejemplo para estaciones
INSERT INTO estaciones (nombre, equipo_principal_id, equipo_secundario_id, ubicacion_id, responsable_id) VALUES
('Estación Administración 1', 1, 2, 1, 1),
('Estación Sistemas Principal', 1, NULL, 4, 1),
('Estación RH Planta 1', 2, NULL, 2, 1);

-- Agregar más equipos de ejemplo para tener datos completos
INSERT INTO equipos (tipo_id, marca_id, modelo, numero_serie, estado_id, descripcion) VALUES
(2, 2, 'EliteDesk 800', 'SN87654321', 2, 'PC de escritorio para administración'),
(3, 4, 'LaserJet Pro', 'SN11223344', 1, 'Impresora láser para oficina'),
(1, 3, 'ThinkPad E14', 'SN55667788', 2, 'Laptop para área de sistemas');

-- Actualizar las estaciones con los nuevos equipos
UPDATE estaciones SET equipo_principal_id = 3, equipo_secundario_id = 4 WHERE id = 1;
UPDATE estaciones SET equipo_principal_id = 5 WHERE id = 2;
UPDATE estaciones SET equipo_principal_id = 6 WHERE id = 3;

INSERT INTO equipo_tipo (nombre, descripcion) VALUES 
('Monitor', 'Dispositivo de visualizacion');