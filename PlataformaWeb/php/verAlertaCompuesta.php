<?php
//$usuario_id_usuario = $_POST["id_usuario"];

$usuario_id_usuario = "1";

//$buscar = "1"; //id usuario
// array for JSON response
//$response = array();
// include db connect class
require_once 'conexion/connectbd.php';
//require_once 'config.php';

// connecting to db
$db = new DB_CONNECT();

verAlertaCompuesta();
function verAlertaCompuesta(){
    $response = array();

    $query = "SELECT distinct id_alerta_compuesta, nombre_alerta_compuesta, nombre_alerta, operador, estado_alerta FROM alerta_compuesta a,  composicion b, operador c, alerta d WHERE a.hogar_id_hogar = 1 AND b.alerta_compuesta_id_alerta_compuesta = a.id_alerta_compuesta AND c.id_operador = b.operador_id_operador AND b.alerta_id_alerta = d.id_alerta";  

    $result = mysql_query($query) or die(mysql_error());
    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response = array();
        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $datos = array();
            $datos["id_alerta_compuesta"] = $row["id_alerta_compuesta"];
            $datos["nombre_alerta_compuesta"] = $row["nombre_alerta_compuesta"];
            $datos["nombre_alerta"] = $row["nombre_alerta"];
            $datos["operador"]     = $row["operador"];
            $datos["estado_alerta"]     = $row["estado_alerta"];
            // push single product into final response array
            array_push($response, $datos);
        }
        // success
        //$response["success"] = 1;
        // echoing JSON response
        echo json_encode($response);
    } else {
        // no products found
        //$response["success"] = 0;
        $response["message"] = "no hay alertas por ahora";
        // echo no users JSON
        echo json_encode($response);
    }
}