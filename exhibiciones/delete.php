<?php
include_once "../config.php";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "DELETE FROM exhibiciones WHERE id_exhibicion=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: read.php");
exit;
?>