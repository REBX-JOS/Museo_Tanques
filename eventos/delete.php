<?php
include_once "../config.php";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "DELETE FROM eventos WHERE id_evento=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: read.php");
exit;
?>