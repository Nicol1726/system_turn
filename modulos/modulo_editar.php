<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
include "../db.php";

$id = $_GET['id'];
$m = $conn->query("SELECT * FROM modulos WHERE id=$id")->fetch_assoc();
?>

<link rel="stylesheet" href="../css/estilos.css">

<div class="container">
    <h1>Editar Módulo</h1>

    <form method="POST" action="modulo_update.php">
        <input type="hidden" name="id" value="<?= $m['id'] ?>">

        <label>Nombre:</label>
        <input name="nombre" value="<?= $m['nombre'] ?>" required>

        <button class="btn">Actualizar</button>
    </form>

    <a class="btn" href="modulos_listar.php">Volver</a>
</div>
