<?php
$host = "localhost";
$user = "root";

$pass = getenv('MYSQL_SECURE_PASSWORD'); 
$db = "sistema_turnos";


if ($pass === false) {
    die("Error: La variable de entorno MYSQL_SECURE_PASSWORD no está configurada.");
}

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>