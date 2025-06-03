<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM eventos WHERE id_evento=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $evento = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fecha_in = $_POST["fecha_in"];
        $fecha_fin = $_POST["fecha_fin"];
        $nombre_evento = $_POST["nombre_evento"];
        $descripcion_evento = $_POST["descripcion_evento"];

        $sql = "UPDATE eventos SET fecha_in=?, fecha_fin=?, nombre_evento=?, descripcion_evento=? WHERE id_evento=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $fecha_in, $fecha_fin, $nombre_evento, $descripcion_evento, $id);
        if ($stmt->execute()) {
            $msg = "Evento actualizado correctamente.";
            // Refrescar datos
            $sql = "SELECT * FROM eventos WHERE id_evento=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $evento = $result->fetch_assoc();
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
    <title>Editar Evento</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Evento</h2>
<form method="post">
    Fecha Inicio: <input type="datetime-local" name="fecha_in" value="<?= date('Y-m-d\TH:i', strtotime($evento['fecha_in'])) ?>" required><br>
    Fecha Fin: <input type="datetime-local" name="fecha_fin" value="<?= date('Y-m-d\TH:i', strtotime($evento['fecha_fin'])) ?>" required><br>
    Nombre Evento: <input type="text" name="nombre_evento" maxlength="100" value="<?= htmlspecialchars($evento['nombre_evento']) ?>" required><br>
    Descripción: <input type="text" name="descripcion_evento" maxlength="255" value="<?= htmlspecialchars($evento['descripcion_evento']) ?>" required><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>