<?php

//$usuario_id_usuario = $_POST["id_usuario"];
$usuario_id_usuario = "1";
$sensor_id_sensor = "1";
$nombre_alerta = $_GET["nombre_alerta_simple"];
$nombre_sensor = $_GET["nombre_sensor_alerta"];
$simbolo = $_GET["simbolo_alerta"];
$dato =$_GET["dato_alerta"];

//$buscar = "1"; //id usuario
// array for JSON response
//$response = array();
// include db connect class
require_once 'conexion/connectbd.php';
//require_once 'config.php';

// connecting to db
$db = new DB_CONNECT();

crearAlertaSimple($usuario_id_usuario, $sensor_id_sensor,$nombre_alerta,$nombre_sensor,$simbolo,$dato);

function crearAlertaSimple($usuario_id_usuario, $sensor_id_sensor,$nombre_alerta,$nombre_sensor,$simbolo,$dato){		  

    $response = array();

    $query = "INSERT INTO alerta (dispositivo_id_dispositivo, nombre_alerta, sensor, signo, valor, fecha, estado) 
			 VALUES ('$sensor_id_sensor', '$nombre_alerta', '$nombre_sensor', '$simbolo', '$dato', NOW(),'0')";
    
    $result = mysql_query($query) or die(mysql_error());

    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response["success"] = "1";
        
        // success
        //$response["success"] = 1;
        // echoing JSON response
        echo json_encode($response);
    } else {
        // no products found
        //$response["success"] = 0;
        $response["success"] = "1";
        // echo no users JSON
        echo json_encode($response);
    }
}//crearAlertaSimple

