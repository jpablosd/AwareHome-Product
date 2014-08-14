<?php

// Parametros de base de datos


$mysql_servidor = "localhost";
$mysql_base = "jpsoto";
$mysql_usuario = "root";
$mysql_clave = "ips017cl";


$id_habitacion = htmlspecialchars($_GET["id_habitacion"],ENT_QUOTES);
$nombre_sensor = htmlspecialchars($_GET["nombre_sensor"],ENT_QUOTES);
$temperatura   = htmlspecialchars($_GET["temperatura"],ENT_QUOTES);
$humedad       = htmlspecialchars($_GET["humedad"],ENT_QUOTES);


/**
/ASI SI INSERTA OJO! PROBLEMA ARRIBA EN EL ENVIO DE DATOS DESDE ARDUINO REVISA CABLE 

$id_habitacion = "1";
$nombre_sensor = "tyh";
$temperatura   = "15";
$humedad       = "45";
*/



// Valida que esten presente todos los parametros
if (($id_habitacion!="") and ($nombre_sensor!="") and ($temperatura!="") and ($humedad!="")) {

	mysql_connect($mysql_servidor,$mysql_usuario,$mysql_clave) or die ("Imposible conectarse al servidor.");

	mysql_select_db($mysql_base) or die("Imposible abrir Base de datos");

	$sql = "insert into sensor_temperatura_humedad (habitacion_id_habitacion, nombre_sensor, temperatura, humedad, fecha) values ('$id_habitacion', '$nombre_sensor', '$temperatura', '$humedad', NOW())";
	mysql_query($sql);
}
?>