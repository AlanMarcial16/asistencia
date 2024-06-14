<?php
$mysqli = new mysqli("localhost", "root", "", "prueba");
if($mysqli->connect_error){
    die("Connection failed: ".$mysqli->connect_error);
}
echo "Connected successfully";
$mysqli->close()
?>
