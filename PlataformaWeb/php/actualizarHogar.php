<?php
require_once 'conexion/connectbd.php';
// connecting to db
$db = new DB_CONNECT();

$idHogar = $_GET["id_hogar"];
$direccionHogar  = $_GET["direccion_hogar"];
$latHogar  = $_GET["lat_hogar"];
$lngHogar  = $_GET["lng_hogar"];


actualizarHogar($idHogar, $direccionHogar, $latHogar, $lngHogar);

function actualizarHogar($idHogar, $direccionHogar, $latHogar, $lngHogar){
    $query2 = "UPDATE ubicacion_hogar a, hogar b SET a.direccion = '$direccionHogar', a.lat = '$latHogar', a.lng = '$lngHogar' WHERE a.id_ubicacion_hogar = b.ubicacion_hogar_id_ubicacion_hogar AND  b.id_hogar = '$idHogar'";  
    $result2 = mysql_query($query2) or die(mysql_error());
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
}