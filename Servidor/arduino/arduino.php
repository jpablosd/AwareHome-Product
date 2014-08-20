<?php
$id_sensor 	   = htmlspecialchars($_GET["id_sensor"],ENT_QUOTES);
$id_usuario 	   = htmlspecialchars($_GET["id_usuario"],ENT_QUOTES);
$nombre_sensor = htmlspecialchars($_GET["nombre_sensor"],ENT_QUOTES);
$temperatura   = htmlspecialchars($_GET["temperatura"],ENT_QUOTES);
$humedad       = htmlspecialchars($_GET["humedad"],ENT_QUOTES);

/**
/ASI SI INSERTA OJO! PROBLEMA ARRIBA EN EL ENVIO DE DATOS DESDE ARDUINO REVISA CABLE 

Datos a ingresar
id_sensor_temperatura_humedad
usuario_id_usuario
nombre_sensor
temperatura
humedad
fecha
*/

// Valida que esten presente todos los parametros
if (($id_sensor!="") and ($id_usuario!="") and ($nombre_sensor!="") and ($temperatura!="") and ($humedad!="")) {

	require_once '../conexion/connectbd.php';
	$db = new DB_Connect();
	$db->connect();
	
	$sql = "insert into sensor_temperatura_humedad (habitacion_id_habitacion, nombre_sensor, temperatura, humedad, fecha) values ('$id_habitacion', '$nombre_sensor', '$temperatura', '$humedad', NOW())";
	mysql_query($sql);
}
?>