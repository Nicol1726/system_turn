<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
include "../db.php";

$id = $_POST['id'];
$nombre = $_POST['nombre'];

$conn->query("UPDATE modulos SET nombre='$nombre' WHERE id=$id");

header("Location: modulos_listar.php");
exit;
?>
