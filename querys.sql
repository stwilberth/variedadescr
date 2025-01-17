

use variedadescr;

-- Active: 1731212519931@@127.0.0.1@3306
-- cambiar el tipo de dato de la columna oferta a enum
ALTER TABLE productos MODIFY COLUMN oferta ENUM('0', '1', '2') DEFAULT '0';

-- eliminar de la tabla productos las columnas nuevo, destacado, slider, fecha_inicio, fecha_fin, moneda, descuento, codigo
ALTER TABLE productos DROP COLUMN nuevo, DROP COLUMN destacado, DROP COLUMN slider, DROP COLUMN fecha_inicio, DROP COLUMN fecha_fin, DROP COLUMN moneda, DROP COLUMN descuento, DROP COLUMN codigo;

CREATE TABLE subscribers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);
