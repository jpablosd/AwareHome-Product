<?php

require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();


verHogar();

function verHogar(){
	$usuario_id_usuario = '1';
 
	$query = "select nombre_hogar, lat, lng, direccion from ubicacion_hogar a, hogar b where a.id_ubicacion_hogar = b.ubicacion_hogar_id_ubicacion_hogar AND b.ubicacion_hogar_id_ubicacion_hogar = 1";  
	$result = mysql_query($query) or die(mysql_error());
	
	// check for empty result
	if (mysql_num_rows($result) > 0) {
		// looping through all results
		// products node
		$response["hogar"] = array();
		while ($row = mysql_fetch_array($result)) {
			// temp user array
			$datos = array();
			$datos["nombre_hogar"] = $row["nombre_hogar"];
			$datos["lat"] = $row["lat"];
            $datos["lng"] = $row["lng"];
            $datos["direccion"] = $row["direccion"];

			// push single product into final response array
			array_push($response["hogar"], $datos);
		}
		// success
		$response["success"] = 1;
		// echoing JSON response
		echo json_encode($response);
	} else {
		// no products found
		$response["success"] = 0;
		$response["message"] = "no hay hogar por ahora";
		// echo no users JSON
		echo json_encode($response);
	}
}//monitoreo de alertas
?>