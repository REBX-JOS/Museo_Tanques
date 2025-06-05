<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST["fecha"];
    $nombre = $_POST["nombre_batalla"];
    $lugar = $_POST["lugar_batalla"];
    $desc = $_POST["descripcion_batalla"];
    // NO incluyas id_batalla en el INSERT
    $sql = "INSERT INTO batallas (fecha, nombre_batalla, lugar_batalla, descripcion_batalla) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fecha, $nombre, $lugar, $desc);
    if ($stmt->execute()) {
        $msg = "Batalla creada correctamente. ID: " . $conn->insert_id;
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Batalla</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Batalla</h2>
<form method="post">
    <!-- Eliminado el campo para ingresar el ID manualmente -->
    Fecha: <input type="date" name="fecha" required><br>
    Nombre: <input type="text" name="nombre_batalla" required><br>
    Lugar: <input type="text" name="lugar_batalla" required><br>
    Descripción (máx 50): <input type="text" name="descripcion_batalla" maxlength="50" required><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>