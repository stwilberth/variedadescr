-- cambiar el tipo de dato de la columna oferta a enum
ALTER TABLE productos MODIFY COLUMN oferta ENUM('0', '1', '2') DEFAULT '0';

-- eliminar de la tabla productos las columnas nuevo, destacado, slider, fecha_inicio, fecha_fin, moneda, descuento, codigo
ALTER TABLE productos DROP COLUMN nuevo, DROP COLUMN destacado, DROP COLUMN slider, DROP COLUMN fecha_inicio, DROP COLUMN fecha_fin, DROP COLUMN moneda, DROP COLUMN descuento, DROP COLUMN codigo;


