<?php
require_once 'conexion/connectbd.php';
//$usuario_id_usuario = $_POST["id_usuario"];
$usuario_id_usuario = "1";
// connecting to db
$db = new DB_CONNECT();

/*
$getdate();
Array
(
    [seconds] => 40
    [minutes] => 58
    [hours]   => 21
    [mday]    => 17
    [wday]    => 2
    [mon]     => 6
    [year]    => 2003
    [yday]    => 167
    [weekday] => Tuesday
    [month]   => June
    [0]       => 1055901520
)
*/

$fecha = getdate();
//echo $hoy[weekday];
$hoy = $fecha[weekday];

/**
    ACTUALIZAR ALERTAS
*/
verAlertasCompuestas($hoy);
function verAlertasCompuestas($hoy){
    $query = "SELECT id_alerta_compuesta FROM alerta_compuesta";
    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $id_alerta_compuesta = $row["id_alerta_compuesta"];
            //echo $row["id_alerta_compuesta"]."<br>";
            selectAlertaCompuesta($id_alerta_compuesta, $hoy);
        }
    }else{
        echo "no hay datos";
    }
}
function selectAlertaCompuesta($id_alerta_compuesta, $hoy){
    //echo $id_alerta_compuesta."<br>";

    $query = "SELECT DISTINCT a.id_alerta_compuesta, group_concat(distinct concat(c.estado, ' ', d.operador) order by b.orden) as composicion, b.orden, a.nombre_alerta_compuesta, a.estado_alerta, a.hogar_id_hogar,    e.lunes, e.martes, e.miercoles, e.jueves, e.sabado, e.domingo FROM alerta_compuesta a, composicion b, alerta c, operador d, repeticion e, sensor f WHERE a.id_alerta_compuesta = b.alerta_compuesta_id_alerta_compuesta AND d.id_operador = b.operador_id_operador AND c.id_alerta = b.alerta_id_alerta AND e.id_repeticion = a.repeticion_id_repeticion AND c.sensor = f.id_sensor AND a.id_alerta_compuesta = '$id_alerta_compuesta'";

    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $id_alerta_compuesta_actualizar     = $row["id_alerta_compuesta"];
            $estado_alerta_compuesta_actualizar;

            $lunes      =$row["lunes"];
            $martes     =$row["martes"];
            $miercoles  =$row["miercoles"];
            $jueves     =$row["jueves"];
            $viernes    =$row["viernes"];
            $sabado     =$row["sabado"];
            $domingo    =$row["domingo"];

            $orden = $row["orden"];

            if($hoy == Monday and $lunes == 1){
                if ($orden == 2){
                    $composicion = explode(',', $row["composicion"]);
                    //echo $composicion[0]."<br>";
                    //echo $composicion[1]."<br>";
                    $compuesto1 = explode(' ', $composicion[0]);
                    $compuesto2 = explode(' ', $composicion[1]);
                    $estado1 = $compuesto1[0];
                    $operador = $compuesto1[1];
                    $estado2 = $compuesto2[0];

                    if($operador == "OR"){
                        if($estado1 or $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }///if operador or
                    if($operador == "AND"){
                        if($estado1 and $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }//if operador and
                    actualizarAlertaCompuesta($id_alerta_compuesta_actualizar, $estado_alerta_compuesta_actualizar);
                }//if orden
            }
            if($hoy == Tuesday and $martes == 1){
                if ($orden == 2){
                    $composicion = explode(',', $row["composicion"]);
                    //echo $composicion[0]."<br>";
                    //echo $composicion[1]."<br>";
                    $compuesto1 = explode(' ', $composicion[0]);
                    $compuesto2 = explode(' ', $composicion[1]);
                    $estado1 = $compuesto1[0];
                    $operador = $compuesto1[1];
                    $estado2 = $compuesto2[0];

                    if($operador == "OR"){
                        if($estado1 or $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }///if operador or
                    if($operador == "AND"){
                        if($estado1 and $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }//if operador and
                    actualizarAlertaCompuesta($id_alerta_compuesta_actualizar, $estado_alerta_compuesta_actualizar);
                }//if orden

            }
            if($hoy == Wednesday and $miercoles == 1){
                if ($orden == 2){
                    $composicion = explode(',', $row["composicion"]);
                    //echo $composicion[0]."<br>";
                    //echo $composicion[1]."<br>";
                    $compuesto1 = explode(' ', $composicion[0]);
                    $compuesto2 = explode(' ', $composicion[1]);
                    $estado1 = $compuesto1[0];
                    $operador = $compuesto1[1];
                    $estado2 = $compuesto2[0];

                    if($operador == "OR"){
                        if($estado1 or $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }///if operador or
                    if($operador == "AND"){
                        if($estado1 and $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }//if operador and
                    actualizarAlertaCompuesta($id_alerta_compuesta_actualizar, $estado_alerta_compuesta_actualizar);
                }//if orden

            }
            if($hoy == Thursday and $jueves == 1){
                if ($orden == 2){
                    $composicion = explode(',', $row["composicion"]);
                    //echo $composicion[0]."<br>";
                    //echo $composicion[1]."<br>";
                    $compuesto1 = explode(' ', $composicion[0]);
                    $compuesto2 = explode(' ', $composicion[1]);
                    $estado1 = $compuesto1[0];
                    $operador = $compuesto1[1];
                    $estado2 = $compuesto2[0];

                    if($operador == "OR"){
                        if($estado1 or $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }///if operador or
                    if($operador == "AND"){
                        if($estado1 and $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }//if operador and
                    actualizarAlertaCompuesta($id_alerta_compuesta_actualizar, $estado_alerta_compuesta_actualizar);
                }//if orden

            }
            if($hoy == Friday and $viernes == 1){
                if ($orden == 2){
                    $composicion = explode(',', $row["composicion"]);
                    //echo $composicion[0]."<br>";
                    //echo $composicion[1]."<br>";
                    $compuesto1 = explode(' ', $composicion[0]);
                    $compuesto2 = explode(' ', $composicion[1]);
                    $estado1 = $compuesto1[0];
                    $operador = $compuesto1[1];
                    $estado2 = $compuesto2[0];

                    if($operador == "OR"){
                        if($estado1 or $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }///if operador or
                    if($operador == "AND"){
                        if($estado1 and $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }//if operador and
                    actualizarAlertaCompuesta($id_alerta_compuesta_actualizar, $estado_alerta_compuesta_actualizar);
                }//if orden

            }
            if($hoy == Saturday and $sabado == 1){
                if ($orden == 2){
                    $composicion = explode(',', $row["composicion"]);
                    //echo $composicion[0]."<br>";
                    //echo $composicion[1]."<br>";
                    $compuesto1 = explode(' ', $composicion[0]);
                    $compuesto2 = explode(' ', $composicion[1]);
                    $estado1 = $compuesto1[0];
                    $operador = $compuesto1[1];
                    $estado2 = $compuesto2[0];

                    if($operador == "OR"){
                        if($estado1 or $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }///if operador or
                    if($operador == "AND"){
                        if($estado1 and $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }//if operador and
                    actualizarAlertaCompuesta($id_alerta_compuesta_actualizar, $estado_alerta_compuesta_actualizar);
                }//if orden

            }
            if($hoy == Sunday and $domingo == 1){
                if ($orden == 2){
                    $composicion = explode(',', $row["composicion"]);
                    //echo $composicion[0]."<br>";
                    //echo $composicion[1]."<br>";
                    $compuesto1 = explode(' ', $composicion[0]);
                    $compuesto2 = explode(' ', $composicion[1]);
                    $estado1 = $compuesto1[0];
                    $operador = $compuesto1[1];
                    $estado2 = $compuesto2[0];

                    if($operador == "OR"){
                        if($estado1 or $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }///if operador or
                    if($operador == "AND"){
                        if($estado1 and $estado2){
                            //echo "true";
                            $estado_alerta_compuesta_actualizar = 1;
                        }
                        else{
                            //echo "false";
                            $estado_alerta_compuesta_actualizar = 0;
                        }
                    }//if operador and
                    actualizarAlertaCompuesta($id_alerta_compuesta_actualizar, $estado_alerta_compuesta_actualizar);
                }//if orden

            }
            
            
            else{
                //echo "Todos los dias en 0";
                
            }
        }
    }else{
        echo "no hay datos";
    }
}//select alerta compuesta


function actualizarAlertaCompuesta($id_alerta_compuesta_actualizar, $estado_alerta_compuesta_actualizar){
    //echo $id_alerta_compuesta_actualizar." ".$estado_alerta_compuesta_actualizar;
    $sql = "UPDATE alerta_compuesta SET estado_alerta='$estado_alerta_compuesta_actualizar' WHERE id_alerta_compuesta='$id_alerta_compuesta_actualizar'";
    mysql_query($sql);
}
/**
    ACTUALIZAR ALERTAS CIERRE
*/















