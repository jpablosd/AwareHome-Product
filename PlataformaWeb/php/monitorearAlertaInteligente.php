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

//actualiza_estado_de_alertas();

verAlertas($usuario_id_usuario);

function verAlertas($usuario_id_usuario){		  

    $response = array();

    $query = "SELECT * FROM alerta_compuesta";  

    $result = mysql_query($query) or die(mysql_error());

    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response = array();
        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $datos = array();
            $datos["nombre_alerta_inteligente"] = $row["nombre_alerta_inteligente"];
            $datos["nombre_sensor1"]     = $row["nombre_sensor1"];
            $datos["simbolo_sensor1"]     = $row["simbolo_sensor1"];
            $datos["valor_sensor1"]     = $row["valor_sensor1"];
            $datos["operador_1"]     = $row["operador_1"];

            $datos["nombre_sensor2"]     = $row["nombre_sensor2"];
            $datos["simbolo_sensor2"]     = $row["simbolo_sensor2"];
            $datos["valor_sensor2"]     = $row["valor_sensor2"];
            $datos["operador_2"]     = $row["operador_2"];

            $datos["nombre_sensor3"]     = $row["nombre_sensor3"];
            $datos["simbolo_sensor3"]     = $row["simbolo_sensor3"];
            $datos["valor_sensor3"]     = $row["valor_sensor3"];
            $datos["estado"]     = $row["estado"];

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
}//verAlertas





//echo "hola";

//ACTUALIZA ESTADO
//require_once '../conexion/connectbd.php';
//$db = new DB_Connect();
//$db->connect();



//obtengo los datos de la regla
function actualiza_estado_de_alertas(){ 
    //echo "1";
    //para saber cuantas reglas hay
    //$numero_de_reglas = "SELECT count(*) FROM alerta";
    $numero_de_reglas = "SELECT MAX(id_alerta) FROM alerta";
    $query=mysql_query($numero_de_reglas);
    //echo $query;
    while($rs=mysql_fetch_array($query,MYSQL_BOTH)){
        $id_regla_max = $rs['MAX(id_alerta)'];
    }//while

    //    echo "<br>";
    //    echo "numero alerta: ".$id_regla_max;
    //    echo "<br>";

    for ($i = 1; $i <= $id_regla_max; $i++)
    {       
        //datos de la regla
        //$regla = "SELECT id_regla_basica, sensor_temperatura_humedad_id_sensor_temperatura_humedad, usuario_id_usuario, nombre_regla, sensor, simbolo, dato, estado FROM regla_basica WHERE id_regla_basica = '$i'";        
        $regla = "SELECT id_alerta, sensor_id_sensor, usuario_id_usuario, nombre_alerta, nombre_sensor, simbolo_alerta, dato, estado FROM alerta WHERE id_alerta = '$i'";
        $sentencia=mysql_query($regla);
        //echo $regla;
        while($rs=mysql_fetch_array($sentencia,MYSQL_BOTH)){
            $id_regla_basica = $rs['id_alerta'];
            $sensor_temperatura_humedad_id_sensor_temperatura_humedad = $rs['sensor_id_sensor'];
            $usuario_id_usuario = $rs['usuario_id_usuario'];
            $nombre_regla = $rs['nombre_alerta'];                  
            $sensor = $rs['nombre_sensor'];
            $simbolo = $rs['simbolo_alerta'];
            $dato = $rs['dato'];
            $estado = $rs['estado'];

            //            echo "<br>";
            //            echo $id_regla_basica;
            //            echo "<br>";
            //            echo $sensor_temperatura_humedad_id_sensor_temperatura_humedad;
            //            echo "<br>";
            //            echo $usuario_id_usuario;
            //            echo "<br>";
            //            echo $nombre_regla;
            //            echo "<br>";
            //            echo $sensor;
            //            echo "<br>";
            //            echo $simbolo;
            //            echo "<br>";
            //            echo $dato;
            //            echo "<br>";
            //            echo $estado;
            //            echo "<br>";

        }//while
        //datos de la regla

        //datos del sensor
        //$datos = "SELECT id_sensor_temperatura_humedad,temperatura,humedad FROM sensor_temperatura_humedad WHERE id_sensor_temperatura_humedad = (SELECT MAX(id_sensor_temperatura_humedad) FROM sensor_temperatura_humedad)";
        $datos = "SELECT id_sensor, temperatura, humedad, gas FROM sensor WHERE id_sensor = (SELECT MAX(id_sensor)FROM sensor)";
        $sentencia=mysql_query($datos);
        while($rs=mysql_fetch_array($sentencia,MYSQL_BOTH)){
            $id_sensor = $rs['id_sensor'];
            $temperatura = $rs['temperatura'];
            $humedad = $rs['humedad']; 
            $gas = $rs['gas'];  
        }//while
        //datos del sensor

        //        echo "comparacion de datos asas <br>";
        //        echo $id_sensor." y ".$sensor_temperatura_humedad_id_sensor_temperatura_humedad;
        //comparacion de datos y actualizacion de estado
        if($id_sensor != $sensor_temperatura_humedad_id_sensor_temperatura_humedad)
        {
            if($sensor == "temperatura")
            {
                if($simbolo == "<")
                {
                    if($temperatura < $dato)
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }else
                    {
                        $sql = "UPDATE alerta SET estado = '0' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == ">")
                {
                    //		    echo "simbolo >";
                    if($temperatura > $dato)
                    {
                        //			echo $temperatura." < entre: ".$dato;
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE alerta SET estado = '0' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == "=")
                {
                    if($temperatura == $dato)
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE alerta SET estado = '0' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }   
            }
            //humedad
            if($sensor == "humedad")
            {
                if($simbolo == "<")
                {
                    if($humedad < $dato)
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE alerta SET estado = '0' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == ">")
                {
                    if($humedad > $dato)
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE alerta SET estado = '0' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == "=")
                {
                    if($humedad == $dato)
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE alerta SET estado = '0' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }
            }
            // SENSOR GAS
            if ($sensor == "gas")
            {
                //		echo "sensor gas";
                if($simbolo == "<")
                {
                    if($gas < $dato)
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);	
                    }
                    else
                    {
                        $sql = "UPDATE alerta SET estado = '0' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == ">")
                {
                    if($gas > $dato)
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE alerta SET estado = '0' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == "="){
                    if($gas == $dato)
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE alerta SET estado = '1' WHERE id_alerta = '$i'";
                        mysql_query($sql);
                    }
                }	
            }

        }//if id_sensor
        else{
            //		echo "id_sensor =! a sensor id alerta";
        } 
    }//for
}//actualiza_estado_de_reglas

?>









