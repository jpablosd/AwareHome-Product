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

actualizar_alertas();

verAlertas($usuario_id_usuario);

function verAlertas($usuario_id_usuario){		  
    $response = array();
    
    $query = " SELECT b.nombre_alerta, b.estado, b.sensor, b.signo, b.valor 
FROM hogar a, alerta b WHERE b.hogar_id_hogar = a.id_hogar AND a.usuario_id_usuario = '$usuario_id_usuario'";  
    $result = mysql_query($query) or die(mysql_error());
    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response = array();
        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $datos = array();
            $datos["nombre_alerta"] = $row["nombre_alerta"];
            $datos["estado"]     = $row["estado"];
            $datos["sensor"]     = $row["sensor"];
            $datos["signo"]     = $row["signo"];
            $datos["valor"]     = $row["valor"];
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
//------------------------------------------
function actualizar_alertas(){
    $numero_de_reglas = "SELECT MAX(id_alerta) FROM alerta";
    $query=mysql_query($numero_de_reglas);
    //echo $query;
    while($rs=mysql_fetch_array($query,MYSQL_BOTH)){
        $id_regla_max = $rs['MAX(id_alerta)'];
    }//while

    for ($i = 1; $i <= $id_regla_max; $i++){    
        //datos de la regla
        //$regla = "SELECT id_regla_basica, sensor_temperatura_humedad_id_sensor_temperatura_humedad, usuario_id_usuario, nombre_regla, sensor, simbolo, dato, estado FROM regla_basica WHERE id_regla_basica = '$i'";        
        $regla = "SELECT id_alerta, nombre_alerta, sensor, signo, valor, estado FROM alerta WHERE id_alerta = '$i'";
        $sentencia=mysql_query($regla);
        //echo $regla;
        while($rs=mysql_fetch_array($sentencia,MYSQL_BOTH)){
            $id_regla_basica = $rs['id_alerta'];
            //$usuario_id_usuario = $rs['usuario_id_usuario'];
            $nombre_regla = $rs['nombre_alerta'];                  
            $sensor = $rs['sensor'];
            $simbolo = $rs['signo'];
            $dato = $rs['valor'];
            $estado = $rs['estado'];


            if ($sensor == 1){
                if($simbolo == "<"){
                    if (ultimaMedicion($sensor) < $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
                elseif($simbolo == ">"){
                    if (ultimaMedicion($sensor) > $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
                elseif($simbolo == "="){
                    if (ultimaMedicion($sensor) == $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
                else{
                    actualizarAlerta($id_regla_basica, 0);
                }
            }
            elseif($sensor == 2){
                if($simbolo == "<"){
                    if (ultimaMedicion($sensor) < $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
                elseif($simbolo == ">"){
                    if (ultimaMedicion($sensor) > $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
                elseif($simbolo == "="){
                    if (ultimaMedicion($sensor) == $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
            }
            elseif($sensor == 3){
                if($simbolo == "<"){
                    if (ultimaMedicion($sensor) < $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
                elseif($simbolo == ">"){
                    if (ultimaMedicion($sensor) > $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
                elseif($simbolo == "="){
                    if (ultimaMedicion($sensor) == $dato){
                        actualizarAlerta($id_regla_basica, 1);
                    }else{
                        actualizarAlerta($id_regla_basica, 0);
                    }
                }
            }


        }//while
        //datos de la regla
    }//for
}//actualizar_alertas

function ultimaMedicion($sensor){
    $datos = "SELECT * FROM medicion ORDER BY id_medicion DESC LIMIT 3";
    $sentencia=mysql_query($datos);
    while($rs=mysql_fetch_array($sentencia,MYSQL_BOTH)){
        $id_sensor = $rs['id_medicion'];
        $sensor_id_sensor = $rs['sensor_id_sensor'];
        $medicion = $rs['medicion'];

        if($sensor_id_sensor == $sensor && $sensor == 1 ){
            //echo "medicion: ".$medicion;
            return $medicion;
        }
        elseif($sensor_id_sensor == $sensor && $sensor == 2){
            //echo "medicion: ".$medicion;
            return $medicion;

        }
        elseif($sensor_id_sensor == $sensor && $sensor == 3){
            //echo "medicion: ".$medicion;
            return $medicion;
        }
    }//while
}//ultimaMedicion

function actualizarAlerta($id_alerta, $estado){
    $sql = "UPDATE alerta SET estado = '$estado' WHERE id_alerta = '$id_alerta'";
    mysql_query($sql);
}

?>









