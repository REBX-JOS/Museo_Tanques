<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM paises WHERE id_pais=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pais = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_pais = $_POST["nombre_pais"];
        $capital = $_POST["capital"];
        $region = $_POST["region"];

        $sql = "UPDATE paises SET nombre_pais=?, capital=?, region=? WHERE id_pais=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre_pais, $capital, $region, $id);
        if ($stmt->execute()) {
            $msg = "País actualizado correctamente.";
            // Refrescar datos
            $sql = "SELECT * FROM paises WHERE id_pais=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $pais = $result->fetch_assoc();
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
    <title>Editar País</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar País</h2>
<form method="post">
    Nombre País: <input type="text" name="nombre_pais" maxlength="100" value="<?= htmlspecialchars($pais['nombre_pais']) ?>" required><br>
    Capital: <input type="text" name="capital" maxlength="100" value="<?= htmlspecialchars($pais['capital']) ?>" required><br>
    Región: <input type="text" name="region" maxlength="100" value="<?= htmlspecialchars($pais['region']) ?>" required><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>