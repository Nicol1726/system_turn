<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}

include "../db.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("UPDATE modulos SET estado='activo' WHERE id=$id");
}

header("Location: modulos_listar.php");
exit;
?>
