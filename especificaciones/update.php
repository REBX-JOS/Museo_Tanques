<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM especificaciones WHERE id_tanque=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $especificacion = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $peso_toneladas = $_POST["peso_toneladas"];
        $longitud_metros = $_POST["longitud_metros"];
        $blindaje_mm = $_POST["blindaje_mm"];
        $velocidad_kmh = $_POST["velocidad_kmh"];
        $armamento_principal = $_POST["armamento_principal"];

        $sql = "UPDATE especificaciones SET peso_toneladas=?, longitud_metros=?, blindaje_mm=?, velocidad_kmh=?, armamento_principal=? WHERE id_tanque=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddidsi", $peso_toneladas, $longitud_metros, $blindaje_mm, $velocidad_kmh, $armamento_principal, $id);
        if ($stmt->execute()) {
            $msg = "Especificación actualizada correctamente.";
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
    <title>Editar Especificación</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Especificación</h2>
<form method="post">
    Peso (toneladas): <input type="number" step="0.01" name="peso_toneladas" value="<?= $especificacion['peso_toneladas'] ?>" required><br>
    Longitud (metros): <input type="number" step="0.01" name="longitud_metros" value="<?= $especificacion['longitud_metros'] ?>" required><br>
    Blindaje (mm): <input type="number" name="blindaje_mm" value="<?= $especificacion['blindaje_mm'] ?>" required><br>
    Velocidad (km/h): <input type="number" step="0.01" name="velocidad_kmh" value="<?= $especificacion['velocidad_kmh'] ?>" required><br>
    Armamento principal: <input type="text" name="armamento_principal" maxlength="100" value="<?= $especificacion['armamento_principal'] ?>" required><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>