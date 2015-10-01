<?php
/* start the session */
//session_start();


require_once 'conexion/connectbd.php';

// connecting to db
$db = new DB_CONNECT();

$tbl_name = "usuario";
$tbl_pass = "clave";

// sent from form
$username = $_POST['nombre_usuario'];
$password = $_POST['clave'];


$sql= "SELECT * FROM $tbl_name a, $tbl_pass b WHERE a.nombre_usuario='$username' AND b.clave='$password' AND a.clave_id_clave = b.id_clave";

$result=mysql_query($sql);
// counting table row
$count = mysql_num_rows($result);
// If result matched $username and $password

if($count == 1){
    //header("Location: index.html");
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (5 * 60) ;

    //echo "<br> Bienvenido! " . $_SESSION['username'];
    header('Location: ../app.html');

    //echo "<script>location.href='views/app.html'</script>";
}
else {
    //echo "<br/>Username o Password estan incorrectos.<br>";
    //echo "<script>Materialize.toast('I am a toast!', 4000)</script>";
    echo "<script>location.href='../index.html'</script>";
    //echo "<a href='index.html'>Volver a Intentarlo</a>";
}

?>
