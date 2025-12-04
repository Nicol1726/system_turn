<?php
include "../db.php";

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    $turno = $conn->query("SELECT modulo_id FROM turnos WHERE id=$id")->fetch_assoc();

    if(!$turno){
        die("Turno no encontrado.");
    }

    $modulo = $turno['modulo_id'];

    // Finalizar el turno atendiendo del mismo módulo
    $conn->query("
        UPDATE turnos SET estado='finalizado'
        WHERE estado='atendiendo' AND modulo_id=$modulo
    ");

    // Cambiar el turno actual a atendiendo
    $conn->query("UPDATE turnos SET estado='atendiendo' WHERE id=$id");
}

header("Location: ../dashboard.php");
exit;
?>
