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

verAlertas($usuario_id_usuario);

function verAlertas($usuario_id_usuario){		  
    $response = array();
        
    $query = "SELECT b.nombre_hogar, a.lat, a.lng, a.direccion FROM ubicacion_hogar a, hogar b WHERE b.usuario_id_usuario = '$usuario_id_usuario'";  
    
    $result = mysql_query($query) or die(mysql_error());
    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response = array();
        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $datos = array();
            $datos["nombre_hogar"] = $row["nombre_hogar"];
            $datos["lat"]     = $row["lat"];
            $datos["lng"]     = $row["lng"];
            $datos["direccion"]     = $row["direccion"];
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
        $response["message"] = "no hay direccion de hogar por ahora";
        // echo no users JSON
        echo json_encode($response);
    }
}//verAlertas

?>