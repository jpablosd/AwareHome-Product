<?php


$id_usuario    = htmlspecialchars($_GET["id_usuario"],ENT_QUOTES);
$temperatura   = htmlspecialchars($_GET["temperatura"],ENT_QUOTES);
$humedad       = htmlspecialchars($_GET["humedad"],ENT_QUOTES);
$gas           = htmlspecialchars($_GET["gas"],ENT_QUOTES);




// Valida que esten presente todos los parametros
if (( $id_usuario != "" ) and ( $temperatura != "" ) and ( $humedad != "" ) and ( $gas != "" )) {
	require_once '../conexion/connectbd.php';
	$db = new DB_Connect();
	$db->connect();
	


	$sql = "INSERT INTO medicion (medicion, fecha, hogar_id_hogar, sensor_id_sensor) 
			VALUES ('$temperatura', NOW(), 1, 1)";
	mysql_query($sql);

	$sql1 = "INSERT INTO medicion (medicion, fecha, hogar_id_hogar, sensor_id_sensor) 
			VALUES ('$gas', NOW(), 1, 3)";
	mysql_query($sql1);

	$sql2 = "INSERT INTO medicion (medicion, fecha, hogar_id_hogar, sensor_id_sensor) 
			VALUES ('$humedad', NOW(), 1, 2)";
	mysql_query($sql2);



}
?>



