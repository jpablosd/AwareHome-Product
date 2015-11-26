<?php

$nombre_alerta_compuesta = $_GET['nombre_alerta_compuesta'];
$id_alerta_0 = $_GET['id_alerta_0'];
$operador0 = $_GET['operador0'];
$id_alerta_00 = $_GET['id_alerta_00'];
$operador00 = $_GET['operador00'];
$id_alerta_1 = $_GET['id_alerta_1'];
$operador1 = $_GET['operador1'];
$id_alerta_2 = $_GET['id_alerta_2'];
$operador2 = $_GET['operador2'];

$lunes = $_GET['lunes'];
$martes = $_GET['martes'];
$miercoles = $_GET['miercoles'];
$jueves = $_GET['jueves'];
$viernes = $_GET['viernes'];
$sabado = $_GET['sabado'];
$domingo = $_GET['domingo'];

$orden = $_GET['orden'];

require_once 'conexion/connectbd.php';

// connecting to db
$db = new DB_CONNECT();

insertarRepeticion($lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo);

insertarAlertaCompuesta($nombre_alerta_compuesta);

insertarComposicion($id_alerta_0, $operador0,$id_alerta_00,$operador00,$id_alerta_1,$operador1,$id_alerta_2,$operador2, $orden);

function insertarRepeticion($lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo){
    $query = "Insert into repeticion (lunes, martes, miercoles, jueves, viernes, sabado, domingo) VALUES ('$lunes', '$martes', '$miercoles', '$jueves', '$viernes', '$sabado', '$domingo')";  
    $result = mysql_query($query) or die(mysql_error());
}

function insertarAlertaCompuesta($nombre_alerta_compuesta){
    $query = "INSERT INTO alerta_compuesta(`nombre_alerta_compuesta`,`estado_alerta`,`hogar_id_hogar`,`repeticion_id_repeticion`)VALUES ( '$nombre_alerta_compuesta',0,1,(SELECT id_repeticion FROM `repeticion` ORDER BY `id_repeticion` DESC LIMIT 1));";  
    $result = mysql_query($query) or die(mysql_error());
}

function insertarComposicion($id_alerta_0, $operador0,$id_alerta_00,$operador00,$id_alerta_1,$operador1,$id_alerta_2,$operador2, $orden){
    if($orden <= 2){
        $query = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_0','$operador0',1, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result = mysql_query($query) or die(mysql_error());

        $query2 = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_00','$operador00',2, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result2 = mysql_query($query2) or die(mysql_error());

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


    }else if($orden == 3){
        $query = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_0','$operador0',1, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result = mysql_query($query) or die(mysql_error());

        $query2 = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_00','$operador00',2, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result2 = mysql_query($query2) or die(mysql_error());

        $query3 = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_1','$operador1',3, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result3 = mysql_query($query3) or die(mysql_error());

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
    }


    else if($orden == 4){
        $query = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_0','$operador0',1, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result = mysql_query($query) or die(mysql_error());

        $query2 = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_00','$operador00',2, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result2 = mysql_query($query2) or die(mysql_error());

        $query3 = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_1','$operador1',3, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result3 = mysql_query($query3) or die(mysql_error());

        $query4 = "INSERT INTO composicion ( `alerta_id_alerta`, `operador_id_operador`,`orden`,`alerta_compuesta_id_alerta_compuesta`)
                 VALUES ('$id_alerta_2','$operador2',4, 
                 (SELECT id_alerta_compuesta FROM `alerta_compuesta` ORDER BY `id_alerta_compuesta` DESC LIMIT 1));";  
        $result4 = mysql_query($query4) or die(mysql_error());

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
    }


}