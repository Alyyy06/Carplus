<?php
$servername = "localhost";
$username = "alijim3_botellones";
$password = "Aly.0611";
$dbname = "alijim3_botellones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>