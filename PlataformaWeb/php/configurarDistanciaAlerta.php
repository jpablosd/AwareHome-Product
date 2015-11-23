<?php

require_once 'conexion/connectbd.php';

// connecting to db
$db = new DB_CONNECT();

$idUsuario = $_GET["id_usuario"];
$metros = $_GET["metros"];
$idHogar = $_GET["id_hogar"];


configurarDistanciaAlerta($idUsuario, $metros, $idHogar);
function configurarDistanciaAlerta($idUsuario, $metros, $idHogar){
    $query2 = "UPDATE configuracion SET distancia='$metros' WHERE hogar_id_hogar='$idHogar'";  
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
        $response["success"] = "0";
        // echo no users JSON
        echo json_encode($response);
    }
}