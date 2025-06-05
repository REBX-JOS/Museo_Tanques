<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "SELECT * FROM batallas WHERE id_batalla=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $batalla = $stmt->get_result()->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fecha = $_POST["fecha"];
        $nombre = $_POST["nombre_batalla"];
        $lugar = $_POST["lugar_batalla"];
        $desc = $_POST["descripcion_batalla"];
        $sql = "UPDATE batallas SET fecha=?, nombre_batalla=?, lugar_batalla=?, descripcion_batalla=? WHERE id_batalla=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $fecha, $nombre, $lugar, $desc, $id);
        if ($stmt->execute()) {
            $msg = "Batalla actualizada correctamente.";
        } else {
            $msg = "Error: " . $conn->error;
        }
        // Recarga los datos editados
        $sql = "SELECT * FROM batallas WHERE id_batalla=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $batalla = $stmt->get_result()->fetch_assoc();
    }
} else {
    header("Location: read.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Batalla</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Batalla</h2>
<form method="post">
    Fecha: <input type="date" name="fecha" value="<?= $batalla['fecha'] ?>" required><br>
    Nombre: <input type="text" name="nombre_batalla" value="<?= $batalla['nombre_batalla'] ?>" required><br>
    Lugar: <input type="text" name="lugar_batalla" value="<?= $batalla['lugar_batalla'] ?>" required><br>
    Descripción (máx 50): <input type="text" name="descripcion_batalla" maxlength="50" value="<?= $batalla['descripcion_batalla'] ?>" required><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>