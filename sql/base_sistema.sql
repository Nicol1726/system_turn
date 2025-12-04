CREATE DATABASE IF NOT EXISTS sistema_turnos;
USE sistema_turnos;

CREATE TABLE IF NOT EXISTS modulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    estado ENUM('activo','inactivo') DEFAULT 'activo'
);

INSERT INTO modulos (nombre, estado) VALUES
('Módulo 1','activo'),
('Módulo 2','activo'),
('Módulo 3','activo'),
('Módulo 4','activo'),
('Módulo 5','activo');

CREATE TABLE IF NOT EXISTS turnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_turno VARCHAR(10),
    nombre VARCHAR(30),
    documento VARCHAR(50),
    modulo_id INT,
    estado ENUM('espera','atendiendo','finalizado') DEFAULT 'espera',
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(modulo_id) REFERENCES modulos(id)
);

INSERT INTO turnos (numero_turno, nombre, documento, modulo_id, estado) VALUES
('T-1', 'Juan Pérez', '123456', 1, 'espera'),
('T-2', 'María López', '654321', 2, 'espera'),
('T-3', 'Carlos Gómez', '987654', 3, 'espera');

CREATE TABLE IF NOT EXISTS usuarios_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(50) NOT NULL
);

INSERT INTO usuarios_admin (usuario, password) VALUES
('Nicol@gmail.com', '1234');

