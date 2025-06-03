<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_evento = $_POST["id_evento"];
    $fecha_in = $_POST["fecha_in"];
    $fecha_fin = $_POST["fecha_fin"];
    $nombre_evento = $_POST["nombre_evento"];
    $descripcion_evento = $_POST["descripcion_evento"];

    // Verificar si ya existe un evento con ese ID
    $check = $conn->prepare("SELECT 1 FROM eventos WHERE id_evento = ?");
    $check->bind_param("i", $id_evento);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $msg = "Ya existe un evento con ese ID.";
    } else {
        $sql = "INSERT INTO eventos (id_evento, fecha_in, fecha_fin, nombre_evento, descripcion_evento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $id_evento, $fecha_in, $fecha_fin, $nombre_evento, $descripcion_evento);
        if ($stmt->execute()) {
            $msg = "Evento creado correctamente.";
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Evento</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Evento</h2>
<form method="post">
    ID Evento: <input type="number" name="id_evento" required><br>
    Fecha Inicio: <input type="datetime-local" name="fecha_in" required><br>
    Fecha Fin: <input type="datetime-local" name="fecha_fin" required><br>
    Nombre Evento: <input type="text" name="nombre_evento" maxlength="100" required><br>
    Descripción: <input type="text" name="descripcion_evento" maxlength="255" required><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>