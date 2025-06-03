<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_batalla"];
    $fecha = $_POST["fecha"];
    $nombre = $_POST["nombre_batalla"];
    $lugar = $_POST["lugar_batalla"];
    $desc = $_POST["descripcion_batalla"];
    $sql = "INSERT INTO batallas (id_batalla, fecha, nombre_batalla, lugar_batalla, descripcion_batalla) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id, $fecha, $nombre, $lugar, $desc);
    if ($stmt->execute()) {
        $msg = "Batalla creada correctamente.";
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
    ID Batalla: <input type="number" name="id_batalla" required><br>
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