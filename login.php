<?php
session_start();
include "db.php";

$error = "";

if(isset($_POST['usuario']) && isset($_POST['password'])){
    $u = $_POST['usuario'];
    $p = $_POST['password'];

    $q = $conn->query("SELECT * FROM usuarios_admin WHERE usuario='$u' AND password='$p'");
    if($q->num_rows > 0){
        $_SESSION['admin'] = $u;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-4 offset-md-4">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center text-primary mb-4">Iniciar Sesión</h3>

                <?php if($error): ?>
                    <div class="alert alert-danger text-center"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input name="usuario" type="email" class="form-control mb-3" placeholder="Correo" required>
                    <input name="password" type="password" class="form-control mb-3" placeholder="Contraseña" required>

                    <button class="btn btn-primary w-100" type="submit">Entrar</button>
                </form>

                <a href="index.php" class="btn btn-secondary w-100 mt-2">Volver</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
