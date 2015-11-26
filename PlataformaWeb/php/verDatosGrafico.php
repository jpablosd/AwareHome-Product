<?php
//$usuario_id_usuario = $_POST["id_usuario"];

require_once 'conexion/connectbd.php';
// connecting to db
$db = new DB_CONNECT();


$usuario_id_usuario = "1";
//$buscar = "1"; //id usuario
// array for JSON response
//$response = array();
// include db connect class
$fecha = $_GET['fecha'];

verDatos($usuario_id_usuario, $fecha);

function verDatos($usuario_id_usuario, $fecha){	
    
    
    $response = array();

    //$fecha2 = str_replace("/","-",$fecha);
    $fecha3 = $fecha."  00:00:01";
    $fecha4 = $fecha."  23:59:59";
    
    $query = "SELECT a.nombre_hogar, b.medicion, b.fecha, c.sensor FROM hogar a, medicion b, sensor c WHERE a.usuario_id_usuario = '$usuario_id_usuario' AND c.id_sensor = b.sensor_id_sensor AND b.fecha >= '$fecha3' AND b.fecha <= '$fecha4'";  
    
    
    
    $result = mysql_query($query) or die(mysql_error());
    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response = array();
        $hogar = "";
        $sensor = "";

        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $datos = array();
            $hogar = $row["nombre_hogar"];
            $datos["medicion"]     = $row["medicion"];
            $datos["fecha"]     = $row["fecha"];
            $datos["sensor"]     = $row["sensor"];
            $sensor = $row["sensor"];
            // push single product into final response array
            array_push($response, $datos);
        }
        // success

        // echoing JSON response
        //        $response["success"] = 1;
        //        $response["sensor"] = $sensor;
        //        $response["hogar"] = $hogar;
        echo json_encode($response);
    } else {
        // no products found
        //$response["success"] = 0;
        $response["message"] = "no hay datos por ahora";
        // echo no users JSON
        echo json_encode($response);
    }
}//verAlertas
