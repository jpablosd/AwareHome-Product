<?php
$buscar=$_POST["buscar"];
//$buscar = "1"; //id usuario

// array for JSON response
$response = array();
// include db connect class
require_once '../conexion/connectbd.php';
//require_once 'config.php';

// connecting to db
$db = new DB_CONNECT();
/*
$query = "SELECT a.nombre_tarea, a.descripcion_tarea, a.estado, a.descripcion_estado, a.direccion, a.latitud, a.longitud, b.nombre_cliente, b.telefono_cliente, b.rut 
		  FROM tareas a, clientes b 
		  WHERE a.direccion = '$buscar' 
		  AND a.clientes_idClientes = b.idClientes";

*/
//$query = "SELECT temperatura,humedad FROM sensor_temperatura_humedad WHERE id_sensor_temperatura_humedad = (SELECT MAX(id_sensor_temperatura_humedad) FROM sensor_temperatura_humedad) AND usuario_id_usuario='$buscar'";  
		  
$query = "SELECT a.temperatura, a.humedad, b.gas FROM sensor_temperatura_humedad a, sensor_gas b 
          WHERE a.id_sensor_temperatura_humedad = (SELECT MAX(id_sensor_temperatura_humedad) FROM sensor_temperatura_humedad) 
          AND b.id_sensor_gas = (SELECT MAX(id_sensor_gas) FROM sensor_gas)
          AND  a.usuario_id_usuario='$buscar'";  



$result = mysql_query($query) or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["datos"] = array();
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $datos = array();
        $datos["temperatura"] = $row["temperatura"];
        $datos["humedad"] = $row["humedad"];
        $datos["gas"] = $row["gas"];
        // push single product into final response array
        array_push($response["datos"], $datos);
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
?>
