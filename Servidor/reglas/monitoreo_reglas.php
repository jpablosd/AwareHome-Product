<?php
require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();

monitoreo_de_reglas();

//obtengo los datos de la regla
function monitoreo_de_reglas(){ 
	//para saber cuantas reglas hay
	$numero_de_reglas = "SELECT count(*) FROM regla_basica";
	$query=mysql_query($numero_de_reglas);
	while($rs=mysql_fetch_array($query,MYSQL_BOTH)){
	   	$id_regla_max = $rs['count(*)'];
	}//while
 		
	for ($i = 1; $i <= $id_regla_max; $i ++)
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
	
		//comparacion de datos y actualizacion de estado
		if($id_sensor == $sensor_temperatura_humedad_id_sensor_temperatura_humedad)
		{
			if($sensor == "temperatura")
			{
				if($simbolo == "<")
				{
					if($temperatura < $dato)
					{
						$sql = "UPDATE regla_basica SET  estado = '1' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}else
					{
						$sql = "UPDATE regla_basica SET  estado = '0' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
				}
				if($simbolo == ">")
				{
					if($temperatura > $dato)
					{
						$sql = "UPDATE regla_basica SET  estado = '1' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
					else
					{
						$sql = "UPDATE regla_basica SET  estado = '0' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
				}
				if($simbolo == "=")
				{
					if($temperatura == $dato)
					{
						$sql = "UPDATE regla_basica SET  estado = '1' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
					else
					{
						$sql = "UPDATE regla_basica SET  estado = '0' WHERE id_regla_basica = '$i'";
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
						$sql = "UPDATE regla_basica SET  estado = '1' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
					else
					{
						$sql = "UPDATE regla_basica SET  estado = '0' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
				}
				if($simbolo == ">")
				{
					if($humedad > $dato)
					{
						$sql = "UPDATE regla_basica SET  estado = '1' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
					else
					{
						$sql = "UPDATE regla_basica SET  estado = '0' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
				}
				if($simbolo == "=")
				{
					if($humedad == $dato)
					{
						$sql = "UPDATE regla_basica SET  estado = '1' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
					else
					{
						$sql = "UPDATE regla_basica SET  estado = '0' WHERE id_regla_basica = '$i'";
						mysql_query($sql);
					}
				}
			}
		}//if id_sensor 
	}//for
}//obtener_datos_regla

?>