<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
include "../db.php";

$nombre = $_POST['nombre'];
$conn->query("INSERT INTO modulos (nombre, estado) VALUES ('$nombre', 'activo')");

header("Location: modulos_listar.php");
exit;
?>
