<?php
require_once 'conexion/connectbd.php';
//$usuario_id_usuario = $_POST["id_usuario"];
$usuario_id_usuario = "1";
// connecting to db
$db = new DB_CONNECT();


/**
    VER ALERTAS
*/
verAlertasCompuestas();
function verAlertasCompuestas(){
    $query1 = "SELECT id_alerta_compuesta FROM alerta_compuesta";
    $result1 = mysql_query($query1) or die(mysql_error());
    if (mysql_num_rows($result1) > 0) {
        $response = array();

        while ($row1 = mysql_fetch_array($result1)) {
            $id_alerta_compuesta = $row1["id_alerta_compuesta"];

            $query2 = "SELECT a.id_alerta_compuesta,a.nombre_alerta_compuesta, group_concat(distinct concat(c.nombre_alerta, ' ', d.operador) order by b.orden) as composicion,a.estado_alerta, b.orden FROM alerta_compuesta a, composicion b, alerta c, operador d, repeticion e, sensor f WHERE a.id_alerta_compuesta = b.alerta_compuesta_id_alerta_compuesta AND d.id_operador = b.operador_id_operador AND c.id_alerta = b.alerta_id_alerta AND e.id_repeticion = a.repeticion_id_repeticion AND c.sensor = f.id_sensor AND a.id_alerta_compuesta = '$id_alerta_compuesta'";
            $result2 = mysql_query($query2) or die(mysql_error());
            if (mysql_num_rows($result2) > 0) {
                while ($row2 = mysql_fetch_array($result2)) {

                    $datos = array();

                    $id_alerta_compuesta = $row2["id_alerta_compuesta"];
                    $nombre_alerta_compuesta = $row2["nombre_alerta_compuesta"];
                    $orden = $row2["orden"];
                    //$composicion = $row2["composicion"];
                    $estado = $row2["estado_alerta"];
                    if($estado == 1){
                        $estado = "Activada";
                    }else{
                        $estado = "Desactivada";
                    }

                    if($orden == 2){
                        $composicion = explode(',', $row2["composicion"]);
                        //echo $composicion[0]."<br>";
                        //echo $composicion[1]."<br>";
                        $compuesto1 = explode(' ', $composicion[0]);
                        $compuesto2 = explode(' ', $composicion[1]);
                        $alerta1 = $compuesto1[0];
                        $operador = $compuesto1[1];
                        $alerta2 = $compuesto2[0];
//                        echo $id_alerta_compuesta."<br>";
//                        echo $nombre_alerta_compuesta."<br>";
//                        echo $alerta1."<br>";
//                        echo $operador."<br>";
//                        echo $alerta2."<br>";
//                        echo $estado."<br>";

                        $datos["id_alerta_compuesta"] = $id_alerta_compuesta;
                        $datos["nombre_alerta_compuesta"] = $nombre_alerta_compuesta;                                   
                        $datos["alerta1"] = $alerta1; 
                        $datos["operador"] = $operador;
                        $datos["alerta2"] = $alerta2;
                        $datos["estado"] = $estado;
                        
                        array_push($response, $datos);
                    }else{

                    }
                }
            }else{
                echo "no hay datos";
            }

        }
        echo json_encode($response);
    }else{
        echo "no hay datos";
    }
}
/**
    VER ALERTAS CIERRE
*/