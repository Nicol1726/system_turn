<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}
include "db.php";


$total_espera = $conn->query("SELECT COUNT(*) AS c FROM turnos WHERE estado='espera'")->fetch_assoc()['c'];
$total_atendiendo = $conn->query("SELECT COUNT(*) AS c FROM turnos WHERE estado='atendiendo'")->fetch_assoc()['c'];
$total_finalizado = $conn->query("SELECT COUNT(*) AS c FROM turnos WHERE estado='finalizado'")->fetch_assoc()['c'];


$turnos = $conn->query("
    SELECT t.*, m.nombre AS modulo
    FROM turnos t
    LEFT JOIN modulos m ON m.id = t.modulo_id
    ORDER BY t.id ASC
");


$modulos = $conn->query("SELECT * FROM modulos ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-hover:hover {
            transform: scale(1.05);
            transition: 0.3s;
            cursor: pointer;
        }
        .hidden {
            display: none;
        }
    </style>
</head>

<body class="bg-light">

<div class="container mt-4">

    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Bienvenida, Nicol</h2>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>

        <div class="row mb-4">

        <div class="col-md-4">
            <div class="card text-white bg-warning shadow card-hover">
                <div class="card-body text-center">
                    <h4>En espera</h4>
                    <h1><?= $total_espera ?></h1>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-primary shadow card-hover">
                <div class="card-body text-center">
                    <h4>Atendiendo</h4>
                    <h1><?= $total_atendiendo ?></h1>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success shadow card-hover">
                <div class="card-body text-center">
                    <h4>Finalizados</h4>
                    <h1><?= $total_finalizado ?></h1>
                </div>
            </div>
        </div>

    </div>

 
    <div class="text-center mb-4">
        <button class="btn btn-primary btn-lg me-3" onclick="showTurnos()">Gestionar Turnos</button>
        <button class="btn btn-secondary btn-lg" onclick="showModulos()">Gestionar Módulos</button>
    </div>

 
    <div id="turnosTable" class="hidden">

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="m-0">Gestión de Turnos</h4>
            </div>

            <div class="card-body">
                <table class="table table-hover table-bordered">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Turno</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Módulo</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while($t = $turnos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>
                        <td><b><?= $t['numero_turno'] ?></b></td>
                        <td><?= $t['nombre'] ?></td>
                        <td><?= $t['documento'] ?></td>
                        <td><?= $t['modulo'] ?></td>
                        <td>
                            <?php if($t['estado']=="espera"): ?>
                                <span class="badge bg-warning text-dark">En espera</span>
                            <?php elseif($t['estado']=="atendiendo"): ?>
                                <span class="badge bg-primary">Atendiendo</span>
                            <?php else: ?>
                                <span class="badge bg-success">Finalizado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($t['estado']=="espera"): ?>
                                <a href="turnos/atender.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-primary">Atender</a>
                            <?php elseif($t['estado']=="atendiendo"): ?>
                                <a href="turnos/finalizar.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger">Finalizar</a>
                            <?php else: ?>
                                <span class="text-muted fst-italic">Sin acción</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>


    <div id="modulosTable" class="hidden">

        <div class="card shadow mb-4">
            <div class="card-header bg-secondary text-white">
                <h4 class="m-0">Gestión de Módulos</h4>
            </div>

            <div class="card-body">

                <a href="modulos/modulo_nuevo.php" class="btn btn-success mb-3">Agregar Módulo</a>

                <table class="table table-hover table-bordered">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while($m = $modulos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $m['id'] ?></td>
                        <td><?= $m['nombre'] ?></td>
                        <td>
                            <?php if($m['estado']=='activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="modulos/modulo_editar.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-primary">Editar</a>

                            <?php if($m['estado']=='activo'): ?>
                                <a href="modulos/modulo_inactivar.php?id=<?= $m['id'] ?>" 
                                   class="btn btn-sm btn-warning">Inactivar</a>
                            <?php else: ?>
                                <a href="modulos/modulo_activar.php?id=<?= $m['id'] ?>" 
                                   class="btn btn-sm btn-success">Activar</a>
                            <?php endif; ?>

                            <a href="modulos/modulo_eliminar.php?id=<?= $m['id'] ?>" 
                               class="btn btn-sm btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</div>


<script>
function showTurnos() {
    document.getElementById("turnosTable").classList.remove("hidden");
    document.getElementById("modulosTable").classList.add("hidden");
}
function showModulos() {
    document.getElementById("modulosTable").classList.remove("hidden");
    document.getElementById("turnosTable").classList.add("hidden");
}
</script>

</body>
</html>
