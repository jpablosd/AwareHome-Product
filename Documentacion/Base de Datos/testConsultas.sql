SELECT distinct  e.sensor, signo, valor, operador
	FROM alerta_compuesta a,  composicion b, operador c, alerta d, sensor e
WHERE a.hogar_id_hogar = 1 
	AND b.alerta_compuesta_id_alerta_compuesta = a.id_alerta_compuesta 
	AND c.id_operador = b.operador_id_operador 
	AND b.alerta_id_alerta = d.id_alerta
    AND a.estado_alerta = 0
    AND a.id_alerta_compuesta = 10


SELECT id_composicion, alerta_id_alerta, operador_id_operador, orden, alerta_compuesta_id_alerta_compuesta 
GROUP_CONCAT(DISTINCT alerta_id_alerta ORDER BY id_composicion DESC SEPARATOR ',')
FROM composicion
GROUP BY student_name;





SELECT * from alerta; 
SELECT * from alerta_compuesta;
SELECT * from composicion;
SELECT * from operador;

select * from sensor
select * from medicion limit 0,1000



1 > 50 OR 3 > 30 

'trigger 1'
CREATE DEFINER=`root`@`localhost` TRIGGER `jpablosd_awarehome`.`alerta_AFTER_UPDATE` AFTER UPDATE ON `alerta` FOR EACH ROW
BEGIN
	insert into historial_alerta
    (fecha,
	estado_alerta,
    id_alerta)
    values
    (NOW(),
    NEW.estado,
    OLD.id_alerta);
END




'trigger 2'
CREATE DEFINER=`root`@`localhost` TRIGGER `jpablosd_awarehome`.`alerta_compuesta_AFTER_UPDATE` AFTER UPDATE ON `alerta_compuesta` FOR EACH ROW
BEGIN
	insert into historial_alerta_compuesta
    (fecha,
	estado_alerta_compuesta,
    id_alerta_compuesta)
    values
    (NOW(),
    NEW.estado_alerta,
    OLD.id_alerta_compuesta);    
END 

SELECT * FROM jpablosd_awarehome.repeticion;

INSERT INTO `jpablosd_awarehome`.`repeticion`
(`lunes`,
`martes`,
`miercoles`,
`jueves`,
`viernes`,
`sabado`,
`domingo`)
VALUES
(1,1,false,false,false,false,false);


SELECT distinct nombre_alerta_compuesta, nombre_alerta,  operador, estado_alerta, orden 
FROM `jpablosd_awarehome`.`alerta_compuesta` a,  `jpablosd_awarehome`.`composicion` b, `jpablosd_awarehome`.`operador` c, `jpablosd_awarehome`.`alerta` d, `jpablosd_awarehome`.`sensor` e
WHERE a.hogar_id_hogar = 1
AND b.alerta_compuesta_id_alerta_compuesta = a.id_alerta_compuesta
AND c.id_operador = b.operador_id_operador
AND b.alerta_id_alerta = d.id_alerta
ORDER BY orden ASC;


SELECT distinct nombre_alerta_compuesta, nombre_alerta, operador, estado_alerta, e.sensor  
FROM alerta_compuesta a,  composicion b, operador c, alerta d, sensor e
WHERE a.hogar_id_hogar = 1 
AND b.alerta_compuesta_id_alerta_compuesta = a.id_alerta_compuesta 
AND c.id_operador = b.operador_id_operador 
AND b.alerta_id_alerta = d.id_alerta
AND e.id_sensor = d.sensor

SELECT distinct id_alerta_compuesta,nombre_alerta_compuesta, nombre_alerta, operador, estado_alerta  
FROM alerta_compuesta a,  composicion b, operador c, alerta d, sensor e
WHERE a.hogar_id_hogar = 1 
AND b.alerta_compuesta_id_alerta_compuesta = a.id_alerta_compuesta 
AND c.id_operador = b.operador_id_operador 
AND b.alerta_id_alerta = d.id_alerta

select fecha from medicion limit 100

SELECT fecha FROM medicion ORDER BY id_medicion DESC LIMIT 1;

SELECT MAX(id_medicion) FROM medicion limit 1;


select nombre_hogar, lat, lng, direccion from ubicacion_hogar a, hogar b 
where a.id_ubicacion_hogar = b.ubicacion_hogar_id_ubicacion_hogar 
AND b.ubicacion_hogar_id_ubicacion_hogar = 1;


SELECT nombre_alerta, estado FROM alerta a, hogar b, usuario c
WHERE a.hogar_id_hogar = b.id_hogar
AND b.usuario_id_usuario = c.id_usuario
AND c.id_usuario = 1


Insert into falso_positivo_alerta (repeticion, tiempo, alerta_id_alerta) 
VALUES (1,2,5);

select * from falso_positivo_alerta_compuesta



//-33.429419 , -71.54317852 -> Santiago
//-33.00923875 , -71.54317852 -> Viña del mar
	
-33.00923875;  
-71.54317852; 


SELECT *, ( 6371 * acos( cos( radians(a.lat) ) * cos( radians( -33.00923875 ) ) 
* cos( radians(  -71.550819) - radians(a.lng) ) + sin( radians(a.lat) ) * sin(radians(-33.00923875)) ) ) AS distance 
FROM ubicacion_hogar a, configuracion b 
HAVING distance < b.distancia
ORDER BY distance 
LIMIT 0 , 20;






