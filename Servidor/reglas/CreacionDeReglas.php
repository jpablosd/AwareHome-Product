<?php

/*
$sensor_temperatura_humedad_id_sensor_temperatura_humedad = '1';
$usuario_id_usuario = '1';
$nombre_regla = 'regla_prueba_3';
$sensor = 'temperatura';
$simbolo = '<';
$dato = '15';
$estado = '0';
*/

$sensor_temperatura_humedad_id_sensor_temperatura_humedad = $_POST['id_sensor'];
$usuario_id_usuario = $_POST['id_usuario'];
$nombre_regla = $_POST['nombre_regla'];
$sensor = $_POST['sensor'];
$simbolo = $_POST['simbolo'];
$dato = $_POST['dato'];
//$estado = $_POST['estado'];

require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();


$query = "INSERT INTO regla_basica (sensor_temperatura_humedad_id_sensor_temperatura_humedad, usuario_id_usuario, nombre_regla, sensor, simbolo, dato, fecha, estado) 
			 VALUES ('$sensor_temperatura_humedad_id_sensor_temperatura_humedad', '$usuario_id_usuario', '$nombre_regla', '$sensor', '$simbolo', '$dato', NOW(), '0')";

mysql_query($query);
// mostramos el ID del registro
//echo mysql_insert_id();

if (mysql_num_rows($query) == 1){
    echo "{\"TAG_SUCCESS\":1}";
}else {
   echo "{\"TAG_SUCCESS\":0}";
}
?>