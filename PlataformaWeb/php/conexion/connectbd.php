<?php

define("DB_HOST", "localhost");
define("DB_USER", "root");//cambiar por el nombre de usuario definido en la configuracion de la BD.
define("DB_PASSWORD", "root");//Modificar por el password 
define("DB_DATABASE", "awarehome-septiembre");//Nombre de la base de datos 


class DB_Connect {
    // constructor
    function __construct() {
        $this->connect();
    }
    // destructor
    function __destruct() {
        // $this->close();
        $this->close();
    }
    // Connecting to database
    public function connect() {
        //require_once 'config.php';
        // connecting to mysql
        $con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
        // selecting database
        mysql_select_db(DB_DATABASE) or die(mysql_error());
        // return database handler
        return $con;
    }
    // Closing database connection
    public function close() {
        mysql_close();
    }
}
?>
