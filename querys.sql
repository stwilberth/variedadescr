-- cambiar el tipo de dato de la columna oferta a enum
ALTER TABLE productos MODIFY COLUMN oferta ENUM('0', '1', '2') DEFAULT '0';


