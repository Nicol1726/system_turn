<!DOCTYPE html>
<html>
<head>
    <title>Solicitar Turno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="col-md-6 offset-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center text-primary mb-4">Solicitar Turno</h3>

                <form method="POST" action="guardar_turno.php">
                    <label>Nombre</label>
                    <input name="nombre" class="form-control mb-3" required>

                    <label>Documento</label>
                    <input name="documento" class="form-control mb-3" required>

                    <button class="btn btn-primary w-100">Generar Turno</button>
                </form>

                <a class="btn btn-secondary w-100 mt-2" href="../index.php">Volver</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
