<?php


$usuario_id_usuario = $_POST["id_usuario"];


//$usuario_id_usuario = "1";


//$buscar = "1"; //id usuario
// array for JSON response
$response = array();
// include db connect class
require_once '../conexion/connectbd.php';
//require_once 'config.php';

// connecting to db
$db = new DB_CONNECT();

		  
$query = "SELECT nombre_alerta, estado FROM alerta WHERE usuario_id_usuario = '$usuario_id_usuario'";  


$result = mysql_query($query) or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["alertas"] = array();
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $datos = array();
        $datos["nombre_alerta"] = $row["nombre_alerta"];
        $datos["estado"]     = $row["estado"];

        // push single product into final response array
        array_push($response["alertas"], $datos);
    }
    // success
    $response["success"] = 1;
    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "no hay alertas por ahora";
    // echo no users JSON
    echo json_encode($response);
}
?>



<?php

//ACTUALIZA ESTADO

require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();


//actualiza_estado_de_reglas();


//obtengo los datos de la regla
function actualiza_estado_de_reglas(){ 
    //para saber cuantas reglas hay
    $numero_de_reglas = "SELECT count(*) FROM regla_basica";
    $query=mysql_query($numero_de_reglas);
    while($rs=mysql_fetch_array($query,MYSQL_BOTH)){
        $id_regla_max = $rs['count(*)'];
    }//while
    
    
    echo "<br>";
    echo $id_regla_max;
    echo "<br>";
    
    
    for ($i = 0; $i < $id_regla_max; $i++)
    {       
        //datos de la regla
        $regla = "SELECT id_regla_basica, sensor_temperatura_humedad_id_sensor_temperatura_humedad, usuario_id_usuario, nombre_regla, sensor, simbolo, dato, estado FROM regla_basica WHERE id_regla_basica = '$i'";        
        $sentencia=mysql_query($regla);
        while($rs=mysql_fetch_array($sentencia,MYSQL_BOTH)){
            $id_regla_basica = $rs['id_regla_basica'];
            $sensor_temperatura_humedad_id_sensor_temperatura_humedad = $rs['sensor_temperatura_humedad_id_sensor_temperatura_humedad'];
            $usuario_id_usuario = $rs['usuario_id_usuario'];
            $nombre_regla = $rs['nombre_regla'];                  
            $sensor = $rs['sensor'];
            $simbolo = $rs['simbolo'];
            $dato = $rs['dato'];
            $estado = $rs['estado'];
            
            echo "<br>";
            echo $id_regla_basica;
            echo "<br>";
            echo $sensor_temperatura_humedad_id_sensor_temperatura_humedad;
            echo "<br>";
            echo $usuario_id_usuario;
            echo "<br>";
            echo $nombre_regla;
            echo "<br>";
            echo $sensor;
            echo "<br>";
            echo $simbolo;
            echo "<br>";
            echo $dato;
            echo "<br>";
            echo $estado;
            echo "<br>";
            
        }//while
        //datos de la regla

        //datos del sensor
        $datos = "SELECT id_sensor_temperatura_humedad,temperatura,humedad FROM sensor_temperatura_humedad WHERE id_sensor_temperatura_humedad = (SELECT MAX(id_sensor_temperatura_humedad) FROM sensor_temperatura_humedad)";
        $sentencia=mysql_query($datos);
        while($rs=mysql_fetch_array($sentencia,MYSQL_BOTH)){
            $id_sensor = $rs['id_sensor_temperatura_humedad'];
            $temperatura = $rs['temperatura'];
            $humedad = $rs['humedad'];   
        }//while
        //datos del sensor

        echo "comparacion de datos";
        
        //comparacion de datos y actualizacion de estado
        if($id_sensor == $sensor_temperatura_humedad_id_sensor_temperatura_humedad)
        {
            if($sensor == "temperatura")
            {
                if($simbolo == "<")
                {
                    if($temperatura < $dato)
                    {
                        $sql = "UPDATE regla_basica SET estado = '1' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }else
                    {
                        $sql = "UPDATE regla_basica SET estado = '0' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == ">")
                {
                    if($temperatura > $dato)
                    {
                        $sql = "UPDATE regla_basica SET estado = '1' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE regla_basica SET estado = '0' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == "=")
                {
                    if($temperatura == $dato)
                    {
                        $sql = "UPDATE regla_basica SET estado = '1' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE regla_basica SET estado = '0' WHERE id_regla_basica = '$i'";
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
                        $sql = "UPDATE regla_basica SET estado = '1' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE regla_basica SET estado = '0' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == ">")
                {
                    if($humedad > $dato)
                    {
                        $sql = "UPDATE regla_basica SET estado = '1' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE regla_basica SET estado = '0' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                }
                if($simbolo == "=")
                {
                    if($humedad == $dato)
                    {
                        $sql = "UPDATE regla_basica SET estado = '1' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE regla_basica SET estado = '0' WHERE id_regla_basica = '$i'";
                        mysql_query($sql);
                    }
                }
            }
        }//if id_sensor 
    }//for
}//actualiza_estado_de_reglas

?>









