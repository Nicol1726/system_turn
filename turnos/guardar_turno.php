<?php
include "../db.php";

$nombre = $_POST['nombre'];
$documento = $_POST['documento'];

$mod = $conn->query("
    SELECT m.id, m.nombre, COUNT(t.id) AS carga
    FROM modulos m
    LEFT JOIN turnos t ON t.modulo_id=m.id AND t.estado='espera'
    WHERE m.estado='activo'
    GROUP BY m.id
    ORDER BY carga ASC
    LIMIT 1
")->fetch_assoc();

$modulo_id = $mod['id'];
$modulo_nombre = $mod['nombre'];


$conn->query("INSERT INTO turnos (numero_turno) VALUES (NULL)");
$id_turno = $conn->insert_id;
$turno = "T-" . $id_turno;

$conn->query("
    UPDATE turnos SET
        numero_turno='$turno',
        nombre='$nombre',
        documento='$documento',
        modulo_id=$modulo_id,
        estado='espera'
    WHERE id=$id_turno
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Turno generado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 text-center">
    <div class="card shadow col-md-6 offset-md-3">
        <div class="card-body">
            <h2 class="text-success">Turno Generado</h2>

            <h1 class="text-primary display-3"><?= $turno ?></h1>

            <h4>Módulo asignado:</h4>
            <h3><?= $modulo_nombre ?></h3>

            <a class="btn btn-primary w-100 mt-3" href="solicitar_turno.php">Generar otro turno</a>
            <a class="btn btn-secondary w-100 mt-2" href="../index.php">Volver al inicio</a>
        </div>
    </div>
</div>

</body>
</html>
