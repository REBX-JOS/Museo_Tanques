<?php
include_once "../config.php";
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $sql = "DELETE FROM tanques WHERE id_tanque=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: read.php");
        exit;
    } catch (mysqli_sql_exception $e) {
        // Redirige a dependencias
        header("Location: ../dependencies.php?id=$id&tabla=tanques");
        exit;
    }
}
header("Location: read.php");
exit;
?>