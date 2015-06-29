<?php
class funciones_BD { 
    private $db;
    // constructor
    function __construct() {
        require_once '../conexion/connectbd.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
    // destructor
    function __destruct() {
    }

	public function login($user,$passw){
        $consulta = "SELECT COUNT(*) FROM usuario a, clave b WHERE a.nombre_usuario='$user' AND b.clave='$passw'";
        $result = mysql_query($consulta); 
        $count = mysql_fetch_row($result);   
        if ($count[0]==0)
        {
            return true;
        }
        else
        {
            return false;
        }
        }//login
}//funciones bd
?>
