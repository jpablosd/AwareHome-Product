<?php
/* start the session */
//session_start();

$host_db = "localhost";
$user_db = "root";
$pass_db = "root";
$db_name = "awarehome-septiembre";
// Connect to server and select databse.
mysql_connect("$host_db", "$user_db", "$pass_db")or die("Cannot Connect to Data Base.");
mysql_select_db("$db_name")or die("Cannot Select Data Base");

for($i = 0; $i < 10; $i++){

    $temperatura = 10 + $i;
    $sql= "INSERT INTO medicion (medicion, fecha, hogar_id_hogar, sensor_id_sensor) VALUES ('$temperatura', NOW(), '1', '1')";
    $result = mysql_query($sql) or die(mysql_error());
    // check for empty result

    $humedad = 50 + $i;
    $sql2= "INSERT INTO medicion (medicion, fecha, hogar_id_hogar, sensor_id_sensor) VALUES ($humedad, NOW(), '1', '2')";
    $result = mysql_query($sql2) or die(mysql_error());

    $gas = 400 + $i;
    $sql3= "INSERT INTO medicion (medicion, fecha, hogar_id_hogar, sensor_id_sensor) VALUES ($gas, NOW(), '1', '3')";
    $result = mysql_query($sql3) or die(mysql_error());
    
    sleep(1);
    echo $i;
}





//if($count == 1){
//}
//else {
//}
?>
