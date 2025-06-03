<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM exhibicion_evento WHERE id_EVEX=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $relacion = $stmt->get_result()->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_exhibicion = $_POST["id_exhibicion"];
        $id_evento = $_POST["id_evento"];
        $sql = "UPDATE exhibicion_evento SET id_exhibicion=?, id_evento=? WHERE id_EVEX=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $id_exhibicion, $id_evento, $id);
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
    <title>Editar Exhibición-Evento</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Relación Exhibición-Evento</h2>
<form method="post">
    ID Exhibición: <input type="number" name="id_exhibicion" value="<?= $relacion['id_exhibicion'] ?>" required><br>
    ID Evento: <input type="number" name="id_evento" value="<?= $relacion['id_evento'] ?>" required><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>