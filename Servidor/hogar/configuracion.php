<?php

require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();
configuracion();

function configuracion(){
    
    $query = "SELECT distancia FROM configuracion a, hogar b WHERE a.hogar_id_hogar = b.id_hogar AND b.usuario_id_usuario = 1";  
    $result = mysql_query($query) or die(mysql_error());

    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response["configuracion"] = array();
        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $datos = array();
            $datos["distancia"] = $row["distancia"];
            // push single product into final response array
            array_push($response["configuracion"], $datos);
        }
        // success
        $response["success"] = 1;
        // echoing JSON response
        echo json_encode($response);
    } else {
        // no products found
        $response["success"] = 0;
        $response["message"] = "no hay datos por ahora";
        // echo no users JSON
        echo json_encode($response);
    }
}