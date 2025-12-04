<?php
include "db.php";

// Turno actualmente atendido
$turno_actual = $conn->query("
    SELECT t.numero_turno, m.nombre AS modulo
    FROM turnos t
    JOIN modulos m ON m.id = t.modulo_id
    WHERE t.estado='atendiendo'
    ORDER BY t.id ASC
    LIMIT 1
")->fetch_assoc();

// Próximo turno en espera
$turno_siguiente = $conn->query("
    SELECT t.numero_turno, m.nombre AS modulo
    FROM turnos t
    JOIN modulos m ON m.id=t.modulo_id
    WHERE t.estado='espera'
    ORDER BY t.id ASC
    LIMIT 1
")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Turnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .turno-card {
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            background: #e7f0ff;
            transition: transform 0.3s;
            text-align: center;
        }
        .turno-card:hover {
            transform: scale(1.05);
            background: #d0e2ff;
        }
        h1.turno {
            font-size: 50px;
            color: #346fe0;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">SISTEMA DE TURNOS</h1>

    <h2 class="mt-4">Turno siendo atendido</h2>
    <div class="turno-card">
        <h1 class="turno"><?= $turno_actual['numero_turno'] ?? "Ninguno" ?></h1>
        <h4><?= $turno_actual['modulo'] ?? "N/A" ?></h4>
    </div>

    <h2 class="mt-4">Próximo turno en espera</h2>
    <div class="turno-card">
        <h1 class="turno"><?= $turno_siguiente['numero_turno'] ?? "No hay en espera" ?></h1>
        <h4><?= $turno_siguiente['modulo'] ?? "" ?></h4>
    </div>

    <div class="text-center mt-4">
        <a class="btn btn-primary me-2" href="turnos/solicitar_turno.php">Solicitar Turno</a>
        <a class="btn btn-secondary" href="dashboard.php">Administración</a>
    </div>
</div>
</body>
</html>
