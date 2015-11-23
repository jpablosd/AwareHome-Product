<?php
require_once 'conexion/connectbd.php';

// connecting to db
$db = new DB_CONNECT();

$repeticion = $_GET['repeticion'];
$tiempo = $_GET['tiempo'];
$id_Alerta = $_GET['idAlerta'];

falsoPositivoAlerta($repeticion, $tiempo, $id_Alerta);

function falsoPositivoAlerta($repeticion, $tiempo, $id_Alerta){

    $query = "Insert into falso_positivo_alerta (repeticion, tiempo, alerta_id_alerta) VALUES ('$repeticion', '$tiempo', '$id_Alerta')";  

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