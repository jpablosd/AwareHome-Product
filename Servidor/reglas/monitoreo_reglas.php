<?php
require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();

//Datos Regla
$id_regla_basica;
$sensor_temperatura_humedad_id_sensor_temperatura_humedad;
$usuario_id_usuario;
$nombre_regla;
$sensor;
$simbolo;
$dato;
$fecha;
$estado;

//Datos Sensor
$id_sensor;
$temperatura;
$humedad;


obtener_regla();

//obtengo los datos de la regla
function obtener_regla(){ 



 
	$id_regla;//para buscar por regla
	
	
	
	$regla = "SELECT id_regla_basica, sensor_temperatura_humedad_id_sensor_temperatura_humedad, usuario_id_usuario, nombre_regla, sensor, simbolo, dato, estado FROM regla_basica WHERE id_regla_basica != '0'";        
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
		
		
		
		
		//seria como...
		/*
		id regla
			do{
				if($temperatura $simbolo $dato){
					estado (regla x) == 1;
				}
				
			}while(estado(de la regla x) = 1);
		*/
		var_dump($id_regla_basica);
		echo "<br>";
		var_dump($sensor_temperatura_humedad_id_sensor_temperatura_humedad);
		echo "<br>";
		var_dump($usuario_id_usuario);
		echo "<br>";
		var_dump($nombre_regla);
		echo "<br>";
		var_dump($sensor);
		echo "<br>";
		var_dump($simbolo);
		echo "<br>";
		var_dump($dato);
		echo "<br>";
		var_dump($estado);
		
		
		echo "<br>";
		echo "<br>";
	}
}

//obtengo los datos de la temperatura
function obtener_datos(){  

	$regla = "SELECT id_sensor_temperatura_humedad,temperatura,humedad FROM sensor_temperatura_humedad WHERE id_sensor_temperatura_humedad = (SELECT MAX(id_sensor_temperatura_humedad) FROM sensor_temperatura_humedad)";
	$sentencia=mysql_query($regla);
	
			
	while($rs=mysql_fetch_array($sentencia,MYSQL_BOTH)){
	   
		$id_sensor = $rs['id_sensor_temperatura_humedad'];
		$temperatura = $rs['temperatura'];
		$humedad = $rs['humedad'];   
		
		var_dump($id_sensor);
		echo "<br>";
		var_dump($temperatura);
		echo "<br>";
		var_dump($humedad);   
	}
}



/*
$response = array();
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["datos"] = array();
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $datos = array();
        $datos["temperatura"] = $row["temperatura"];
        $datos["humedad"] = $row["humedad"];
        // push single product into final response array
        array_push($response["datos"], $datos);
    }
    // success
    $response["success"] = 1;
    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "no hay mediciones por ahora";
    // echo no users JSON
    echo json_encode($response);
}
*/
?>