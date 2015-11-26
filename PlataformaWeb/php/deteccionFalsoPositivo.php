<?php

/*
DETECCION DE FALSO POSITIVO DE ALERTA SIMPLE
*/

require_once 'conexion/connectbd.php';
//$usuario_id_usuario = $_POST["id_usuario"];
$usuario_id_usuario = "1";
// connecting to db
$db = new DB_CONNECT();
verAlerta();

function verAlerta(){
    $query1 = "SELECT id_alerta FROM alerta";
    $result1 = mysql_query($query1) or die(mysql_error());
    if (mysql_num_rows($result1) > 0) {
        while ($row1 = mysql_fetch_array($result1)) {
            $id_alerta = $row1["id_alerta"];
            falsoPositivo($id_alerta);
        }
    }else{
        echo "no hay datos";
    }
}//verAlerta


function falsoPositivo($id_alerta){
    $query1 = "SELECT id_falso_positivo_alerta, repeticion, tiempo, contador, estado, alerta_id_alerta FROM jpablosd_awarehome.falso_positivo_alerta WHERE alerta_id_alerta = '$id_alerta'";
    $result1 = mysql_query($query1) or die(mysql_error());
    if (mysql_num_rows($result1) > 0) {
        while ($row1 = mysql_fetch_array($result1)) {
            //            echo $row1["id_falso_positivo_alerta"]."<br>";
            //            echo $row1["repeticion"]."<br>";
            //            echo $row1["tiempo"]."<br>";
            //            echo $row1["contador"]."<br>";
            //            echo $row1["alerta_id_alerta"]."<br>";
            //            echo $row1["estado"]."<br>"."<br>";
            $id_alerta = $row1["alerta_id_alerta"];
            $repeticion = $row1["repeticion"];
            $tiempo = $row1["tiempo"];
            $id_falso_positivo = $row1["id_falso_positivo_alerta"];
            /*
                LLamar a las ultimas x historias y si entre la primera y la ultima hay menos del tiempo cambiar el estado a 1
            */
            verHistorial($id_alerta, $repeticion, $tiempo, $id_falso_positivo);
        }
    }else{
        //echo "no hay datos <br>";
    }
}//falsoPositivo

function verHistorial($id_alerta, $repeticion, $tiempo, $id_falso_positivo){
    //    echo $id_alerta."<br>";
    //    echo $repeticion."<br>";
    //    echo $tiempo."<br>";
    $repeticion1 = $repeticion; 

    $query1 = "SELECT fecha, estado_alerta FROM historial_alerta WHERE id_alerta = '$id_alerta' AND estado_alerta = 1 ORDER BY id_historial_alerta DESC LIMIT $repeticion1";
    // echo $query1;

    $result1 = mysql_query($query1) or die(mysql_error());
    if (mysql_num_rows($result1) > 0) {
        $fechas = array();
        while ($row1 = mysql_fetch_array($result1)) {
            array_push($fechas, $row1["fecha"]);
        }
        //echo count($fechas);
        //        echo $fechas[0]."<br>";
        //        echo $fechas[(count($fechas)-1)]."<br>";

        $dteStart = new DateTime($fechas[0]); 
        $dteEnd   = new DateTime($fechas[(count($fechas)-1)]); 
        $dteDiff  = $dteStart->diff($dteEnd); 
        //print $dteDiff->format("%H:%I:%S"); 
        $tiempoTranscurrido = $dteDiff->format("%H:%I:%S");

        list($horas, $minutos, $segundos) = explode(':', $tiempoTranscurrido);
        $hora_en_segundos = ($horas * 3600 ) + ($minutos * 60 ) + $segundos;
        //echo "hora en segundos: ".$hora_en_segundos; 

        if($hora_en_segundos < $tiempo){
            //echo "la alerta es verdadera";
            $estado = 1;
            actualizarFalsoPositivo($id_falso_positivo, $estado);

            //actualizar falso positivo estado
        }else{
            $estado = 0;
            //echo "la alerta no es verdadera";
            actualizarFalsoPositivo($id_falso_positivo, $estado);
        }
    }else{
        echo "no hay datos";
    }
}//verHistorial

function actualizarFalsoPositivo($id_falso_positivo, $estado){
    //echo $id_falso_positivo." ".$estado;

    $query2 = "UPDATE falso_positivo_alerta SET estado='$estado' WHERE id_falso_positivo_alerta='$id_falso_positivo'";  
    $result2 = mysql_query($query2) or die(mysql_error());

}//actualizarFalsoPositivo










