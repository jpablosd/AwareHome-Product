<?php

require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();


monitoreo_de_alertas();


function monitoreo_de_alertas(){
	$usuario_id_usuario = '1';
 
	$query = "SELECT nombre_regla, estado FROM regla_basica WHERE usuario_id_usuario = '$usuario_id_usuario'";  
	$result = mysql_query($query) or die(mysql_error());
	
	// check for empty result
	if (mysql_num_rows($result) > 0) {
		// looping through all results
		// products node
		$response["alertas"] = array();
		while ($row = mysql_fetch_array($result)) {
			// temp user array
			$datos = array();
			$datos["nombre_regla"] = $row["nombre_regla"];
			$datos["estado"] = $row["estado"];
			// push single product into final response array
			array_push($response["alertas"], $datos);
		}
		// success
		$response["success"] = 1;
		// echoing JSON response
		echo json_encode($response);
	} else {
		// no products found
		$response["success"] = 0;
		$response["message"] = "no hay mediciones por ahora";
		// echo no users JSON
		echo json_encode($response);
	}
}//monitoreo de alertas
?>