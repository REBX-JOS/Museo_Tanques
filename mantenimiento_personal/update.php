<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM mantenimiento_personal WHERE id_MP=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $relacion = $stmt->get_result()->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idm = $_POST["id_mantenimiento"];
        $idp = $_POST["id_personal"];
        $sql = "UPDATE mantenimiento_personal SET id_mantenimiento=?, id_personal=? WHERE id_MP=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $idm, $idp, $id);
        if ($stmt->execute()) {
            $msg = "Relación actualizada correctamente.";
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
} else {
    header("Location: read.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Mantenimiento Personal</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Relación Mantenimiento-Personal</h2>
<form method="post">
    ID Mantenimiento: <input type="number" name="id_mantenimiento" value="<?= $relacion['id_mantenimiento'] ?>" required><br>
    ID Personal: <input type="number" name="id_personal" value="<?= $relacion['id_personal'] ?>" required><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>