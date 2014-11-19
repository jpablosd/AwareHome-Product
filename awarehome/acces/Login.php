<?php
/*LOGIN */

$usuario = $_POST['usuario'];
$passw = $_POST['password'];

//$usuario = 'juanpablo.soto';
//$passw = '85575884';

require_once 'Funciones.php';
$db = new funciones_BD();
	if($db->login($usuario,$passw)){
	$resultado[]=array("logstatus"=>"0");
	}else{
	$resultado[]=array("logstatus"=>"1");
	}
echo json_encode($resultado);
?>


