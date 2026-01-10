-- Crear base de datos (opcional si ya tienes una)
CREATE DATABASE IF NOT EXISTS abcd_medica;
USE abcd_medica;

-- Tabla de Usuarios
-- Limpiar tablas existentes para asegurar una importación limpia
DROP TABLE IF EXISTS records;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('patient', 'doctor') DEFAULT 'patient',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar un médico por defecto para pruebas
-- Usuario: doctor@abcdmedica.com | Pass: doctor123
INSERT INTO users (name, email, password, role) 
VALUES ('Dr. Especialista', 'doctor@abcdmedica.com', 'doctor123', 'doctor');

-- Tabla de Expedientes/Registros
CREATE TABLE IF NOT EXISTS records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    symptoms TEXT,
    diagnosis TEXT,
    status VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
