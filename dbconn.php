<?php

$host         = "localhost";
$username     = "root";
$password     = "";
$dbname       = "dbbookstore";

try {
    $dbconn = new PDO('mysql:host=localhost;dbname=dbbookstore', $username, $password);
    //echo 'coneccion exitosa.....!!!!!';
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}





//====================================== coneccion para postgres ==========================================//
// $conn_string = "host=localhost port=5432 dbname=mundo_pituto user=postgres password=123 options='--client_encoding=UTF8'";
// $dbconn = pg_connect($conn_string);
 
// if(!$dbconn) {
// echo "Error: No se ha podido conectar a la base de datos\n";
// } else {
// echo "Conexión exitosa\n";
// }
// pg_close($dbconn);