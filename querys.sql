

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


CREATE TABLE fcm_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    topic VARCHAR(255) NOT NULL DEFAULT 'all',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fcm_tokens_user_id_foreign
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- delete table fcm_tokens
DROP TABLE fcm_tokens;

CREATE TABLE IF NOT EXISTS `fcm_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NULL,
  `token` varchar(255) NOT NULL,
  `topic` varchar(255) DEFAULT 'all',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fcm_tokens_token_unique` (`token`),
  KEY `fcm_tokens_user_id_foreign` (`user_id`),
  CONSTRAINT `fcm_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- eliminar unas tablas: stiempos, ti, tie, wtiempos
DROP TABLE stiempos, ti, tie, wtiempos;
