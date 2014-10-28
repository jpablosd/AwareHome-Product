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
	
	$sql = "INSERT INTO sensor (temperatura, humedad, gas, fecha, usuario_id_usuario) 
			VALUES ('$temperatura', '$humedad', '$gas', NOW(), $id_usuario)";

	mysql_query($sql);
}
?>



