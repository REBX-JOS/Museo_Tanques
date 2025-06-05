<?php
include_once "../config.php";
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $sql = "DELETE FROM batallas WHERE id_batalla=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: read.php");
        exit;
    } catch (mysqli_sql_exception $e) {
        // Redirige a dependencias
        $tabla = "batallas";
        header("Location: ../dependencies.php?id=$id&tabla=$tabla");
        exit;
    }
}
header("Location: read.php");
exit;