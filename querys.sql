

use variedadescr;

-- Active: 1731212519931@@127.0.0.1@3306
-- cambiar el tipo de dato de la columna oferta a enum
ALTER TABLE productos MODIFY COLUMN oferta ENUM('0', '1', '2') DEFAULT '0';

-- eliminar de la tabla productos las columnas nuevo, destacado, slider, fecha_inicio, fecha_fin, moneda, descuento, codigo
ALTER TABLE productos DROP COLUMN nuevo, DROP COLUMN destacado, DROP COLUMN slider, DROP COLUMN fecha_inicio, DROP COLUMN fecha_fin, DROP COLUMN moneda, DROP COLUMN descuento, DROP COLUMN codigo;

CREATE TABLE subscribers (
    id CHAR(36) NOT NULL PRIMARY KEY, -- UUID como clave primaria
    email VARCHAR(255) NOT NULL UNIQUE, -- Correo único
    name VARCHAR(255), -- Nombre del suscriptor
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- delete table subscribers
DROP TABLE subscribers;


CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED DEFAULT NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX (queue)
);



ALTER TABLE `subscribers` 
ADD COLUMN `confirmation_token` VARCHAR(255) NULL,
ADD COLUMN `is_confirmed` TINYINT(1) NOT NULL DEFAULT 0;
