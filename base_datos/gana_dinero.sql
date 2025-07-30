-- Crear base de datos
CREATE DATABASE IF NOT EXISTS gana_dinero DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gana_dinero;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    clave VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    saldo DECIMAL(10,2) DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
