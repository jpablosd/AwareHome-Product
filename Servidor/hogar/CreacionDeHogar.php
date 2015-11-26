<?php

/*
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];
$id_usuario = $_POST['id_usuario'];
*/

$latitud = "latitud";
$longitud = "longitud";
$id_usuario = "1";
//$estado = $_POST['estado'];

require_once '../conexion/connectbd.php';
$db = new DB_Connect();
$db->connect();


$query = "INSERT INTO hogar (latitud, longitud, usuario_id_usuario) 
		VALUES ('$latitud', '$longitud', '$id_usuario')";

mysql_query($query);
// mostramos el ID del registro
//echo mysql_insert_id();

if (mysql_num_rows($query) == 1){
    echo "{\"TAG_SUCCESS\":1}";
}else {
   echo "{\"TAG_SUCCESS\":0}";
}
?>