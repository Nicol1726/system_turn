<?php
include "../db.php";

$id = $_GET['id'];

$conn->query("UPDATE modulos SET estado='inactivo' WHERE id=$id");

header("Location: modulos_listar.php");
?>
