<?php
require_once 'conexion/connectbd.php';

// connecting to db
$db = new DB_CONNECT();

$repeticion = $_GET['repeticion'];
$tiempo = $_GET['tiempo'];
$id_Alerta_compuesta = $_GET['idAlertaCompuesta'];

falsoPositivoAlertaCompuesta($repeticion, $tiempo, $id_Alerta_compuesta);

function falsoPositivoAlertaCompuesta($repeticion, $tiempo, $id_Alerta_compuesta){

    $query = "Insert into falso_positivo_alerta_compuesta (repeticion, tiempo, alerta_compuesta_id_alerta_compuesta) VALUES ('$repeticion', '$tiempo', '$id_Alerta_compuesta')";  

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
        $response["success"] = "1";
        //$response["success"] = "1";
        // echo no users JSON
        echo json_encode($response);
    }
}