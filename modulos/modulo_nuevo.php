<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
?>

<link rel="stylesheet" href="../css/estilos.css">

<div class="container">
    <h1>Agregar Nuevo Módulo</h1>

    <form method="POST" action="modulo_guardar.php">
        <label>Nombre del módulo:</label>
        <input name="nombre" required>

        <button class="btn">Guardar</button>
    </form>

    <a class="btn" href="modulos_listar.php">Volver</a>
</div>
