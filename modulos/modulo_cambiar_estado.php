<?php
session_start();
if(!isset($_SESSION['admin'])){
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

include "../db.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = intval($_POST['id'] ?? 0);
    $estado = $_POST['estado'] ?? '';

    if($id > 0 && in_array($estado, ['activo', 'inactivo'])) {
        $stmt = $conn->prepare("UPDATE modulos SET estado = ? WHERE id = ?");
        $stmt->bind_param('si', $estado, $id);

        if($stmt->execute()){
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la base de datos']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
