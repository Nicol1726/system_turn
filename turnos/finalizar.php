<?php
include "../db.php";

if(isset($_GET['id'])){
    $conn->query("UPDATE turnos SET estado='finalizado' WHERE id=".$_GET['id']);
}

header("Location: ../dashboard.php");
exit;
?>
