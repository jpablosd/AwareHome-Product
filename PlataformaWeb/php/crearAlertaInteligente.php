<?php

//$usuario_id_usuario = $_POST["id_usuario"];
$nombre_alerta_inteligente  = $_GET["nombre_alerta_inteligente"];
$tipoSensor1                = $_GET["tipoSensor1"];
$simboloSensor1             =$_GET["simboloSensor1"];
$valorSensor1                =$_GET["valorSensor1"];
$tipoSensor2                =$_GET["tipoSensor2"];
$simboloSensor2             =$_GET["simboloSensor2"];
$valorSensor2                =$_GET["valorSensor2"];
$tipoSensor3                =$_GET["tipoSensor3"];
$simboloSensor3              =$_GET["simboloSensor3"];
$valorSensor3               =$_GET["valorSensor3"];
$tipoOperador1               =$_GET["tipoOperador1"];
$tipoOperador2              =$_GET["tipoOperador2"];
$fecha                      =$_GET["fecha"];


//$buscar = "1"; //id usuario
// array for JSON response
//$response = array();
// include db connect class
require_once 'conexion/connectbd.php';
//require_once 'config.php';

// connecting to db
$db = new DB_CONNECT();

crearAlertaInteligente($nombre_alerta_inteligente,$tipoSensor1,$simboloSensor1,$valorSensor1,$tipoSensor2,$simboloSensor2,$valorSensor2,$tipoSensor3,$simboloSensor3,$valorSensor3,$tipoOperador1,$tipoOperador2,$fecha);

function crearAlertaInteligente($nombre_alerta_inteligente,$tipoSensor1,$simboloSensor1,$valorSensor1,$tipoSensor2,$simboloSensor2,$valorSensor2,$tipoSensor3,$simboloSensor3,$valorSensor3,$tipoOperador1,$tipoOperador2,$fecha){		  

    $response = array();

    $query = "INSERT INTO alerta_inteligente (nombre_alerta_inteligente,nombre_sensor1,simbolo_sensor1, valor_sensor1, nombre_sensor2, simbolo_sensor2, valor_sensor2, nombre_sensor3, simbolo_sensor3, valor_sensor3, operador_1, operador_2,fecha)	VALUES('$nombre_alerta_inteligente','$tipoSensor1','$simboloSensor1','$valorSensor1','$tipoSensor2','$simboloSensor2','$valorSensor2','$tipoSensor3','$simboloSensor3','$valorSensor3','$tipoOperador1','$tipoOperador2','$fecha')";

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
}//crearAlertaInteligente

