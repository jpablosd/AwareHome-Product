<?php
require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();

$latActual = $_GET['lat_actual'];
$lngActual = $_GET['lng_actual'];
$idUsuario = $_GET['id_usuario'];
$idHogar = $_GET['id_hogar'];

$latHogar = 0;
$longHogar = 0;

$response = array();
$variable = hogar($response);
$latHogar = $variable[0];
$longHogar = $variable[1];

$distancia = distancia($latActual, $lngActual, $latHogar, $longHogar);

$response["distancia"] = round($distancia,4);
$response["success"] = 1;
echo json_encode($response);

function hogar($response){
    $query = "select nombre_hogar, lat, lng, direccion from ubicacion_hogar a, hogar b where a.id_ubicacion_hogar = b.ubicacion_hogar_id_ubicacion_hogar AND b.ubicacion_hogar_id_ubicacion_hogar = 1";  
    $result = mysql_query($query) or die(mysql_error());
    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $datos = array();
            $latHogar = $row["lat"];
            $longHogar = $row["lng"];
            // push single product into final response array
            array_push($response, $latHogar);
            array_push($response, $longHogar);
        }
        return $response;
    }
}

function distancia($lat1, $long1, $latHogar, $longHogar){ 
    $degtorad = 0.01745329; 
    $radtodeg = 57.29577951;
    $dlong = ($long1 - $longHogar); 
    $dvalue = (sin($lat1 * $degtorad) * sin($latHogar * $degtorad)) + (cos($lat1 * $degtorad) * cos($latHogar * $degtorad) * cos($dlong * $degtorad)); 
    $dd = acos($dvalue) * $radtodeg; 
    $miles = ($dd * 69.16); 
    $km = ($dd * 111.302); 
    return $km*1000; 
} 

