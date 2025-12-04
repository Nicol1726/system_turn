<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
include "../db.php";

$modulos = $conn->query("SELECT * FROM modulos ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Módulos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-4 p-4 bg-white rounded shadow">

    <h1 class="mb-4 text-center">Gestión de Módulos</h1>

    <a href="modulo_nuevo.php" class="btn btn-success mb-3">Agregar Módulo</a>

    <table class="table table-striped table-hover align-middle" id="tabla-modulos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($m = $modulos->fetch_assoc()): ?>
            <tr data-id="<?= $m['id'] ?>">
                <td><?= htmlspecialchars($m['id']) ?></td>
                <td><?= htmlspecialchars($m['nombre']) ?></td>
                <td class="estado">
                    <?php if($m['estado']=='activo'): ?>
                        <span class="badge bg-success">Activo</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Inactivo</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="modulo_editar.php?id=<?= $m['id'] ?>" class="btn btn-primary btn-sm me-1">Editar</a>

                    <?php if($m['estado']=='activo'): ?>
                        <button class="btn btn-warning btn-sm me-1 btn-cambiar-estado" data-estado="inactivo">Inactivar</button>
                    <?php else: ?>
                        <button class="btn btn-success btn-sm me-1 btn-cambiar-estado" data-estado="activo">Activar</button>
                    <?php endif; ?>

                    <a href="modulo_eliminar.php?id=<?= $m['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Estás seguro de eliminar este módulo?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="../dashboard.php" class="btn btn-primary">Volver</a>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Escuchar clicks en botones de cambiar estado
    document.querySelectorAll('.btn-cambiar-estado').forEach(button => {
        button.addEventListener('click', function() {
            const tr = this.closest('tr');
            const id = tr.getAttribute('data-id');
            const nuevoEstado = this.getAttribute('data-estado');

            if(!confirm(`¿Seguro que quieres cambiar el estado a "${nuevoEstado}"?`)) return;

            fetch('modulo_cambiar_estado.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `id=${encodeURIComponent(id)}&estado=${encodeURIComponent(nuevoEstado)}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
        
                    const estadoTd = tr.querySelector('.estado');
                    const btnCambiar = tr.querySelector('.btn-cambiar-estado');
                    if(nuevoEstado === 'activo') {
                        estadoTd.innerHTML = '<span class="badge bg-success">Activo</span>';
                        btnCambiar.textContent = 'Inactivar';
                        btnCambiar.classList.remove('btn-success');
                        btnCambiar.classList.add('btn-warning');
                        btnCambiar.setAttribute('data-estado', 'inactivo');
                    } else {
                        estadoTd.innerHTML = '<span class="badge bg-danger">Inactivo</span>';
                        btnCambiar.textContent = 'Activar';
                        btnCambiar.classList.remove('btn-warning');
                        btnCambiar.classList.add('btn-success');
                        btnCambiar.setAttribute('data-estado', 'activo');
                    }
                } else {
                    alert('Error al cambiar el estado: ' + data.message);
                }
            })
            .catch(() => alert('Error en la comunicación con el servidor'));
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
