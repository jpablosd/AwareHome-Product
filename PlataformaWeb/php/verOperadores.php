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

verOperadores();

function verOperadores(){
    $response = array();

    $query = "SELECT * FROM operador";  
    
    $result = mysql_query($query) or die(mysql_error());
    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response = array();
        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $datos = array();
            $datos["id_operador"] = $row["id_operador"];
            $datos["operador"]     = $row["operador"];
            $datos["descripcion_operador"]     = $row["descripcion_operador"];

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