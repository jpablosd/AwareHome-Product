<?php
$id_usuario    = htmlspecialchars($_GET["id_usuario"],ENT_QUOTES);
$nombre_sensor = htmlspecialchars($_GET["nombre_sensor"],ENT_QUOTES);
$temperatura   = htmlspecialchars($_GET["temperatura"],ENT_QUOTES);
$humedad       = htmlspecialchars($_GET["humedad"],ENT_QUOTES);
$gas           = htmlspecialchars($_GET["gas"],ENT_QUOTES);

// Valida que esten presente todos los parametros
if (($id_usuario!="") and ($nombre_sensor!="") and ($temperatura!="") and ($humedad!="") and ($gas!="")) {
	require_once '../conexion/connectbd.php';
	$db = new DB_Connect();
	$db->connect();
	
	$sql = "INSERT INTO sensor_temperatura_humedad (usuario_id_usuario, nombre_sensor, temperatura, humedad, fecha) 
			VALUES ('$id_usuario', '$nombre_sensor', '$temperatura', '$humedad', NOW())";

	$sql2 =	"INSERT INTO sensor_gas (usuario_id_usuario, gas, fecha) 
			 VALUES ('$id_usuario', '$gas', NOW())";
			 
	mysql_query($sql);
	mysql_query($sql2);
}
?>