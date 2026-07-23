CREATE DATABASE AGENCIA;
USE AGENCIA;

CREATE TABLE VUELO (
    id_vuelo INT AUTO_INCREMENT PRIMARY KEY,
    origen VARCHAR(100) NOT NULL,
    destino VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    plazas_disponibles INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

CREATE TABLE HOTEL (
    id_hotel INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    habitaciones_disponibles INT NOT NULL,
    tarifa_noche DECIMAL(10,2) NOT NULL
);

CREATE TABLE RESERVA (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    fecha_reserva DATE NOT NULL,
    id_vuelo INT,
    id_hotel INT,
    FOREIGN KEY (id_vuelo) REFERENCES VUELO(id_vuelo),
    FOREIGN KEY (id_hotel) REFERENCES HOTEL(id_hotel)
);