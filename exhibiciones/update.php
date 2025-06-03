<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM exhibiciones WHERE id_exhibicion=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $exhibicion = $result->fetch_assoc();

    // Cargar tanques para el select
    $tq = $conn->query("SELECT id_tanque FROM tanques");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fecha_exhibicion = $_POST["fecha_exhibicion"];
        $lugar_exhibicion = $_POST["lugar_exhibicion"];
        $descripcion_exhibicion = $_POST["descripcion_exhibicion"];
        $id_tanque = $_POST["id_tanque"] ?: null;

        $sql = "UPDATE exhibiciones SET fecha_exhibicion=?, lugar_exhibicion=?, descripcion_exhibicion=?, id_tanque=? WHERE id_exhibicion=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $fecha_exhibicion, $lugar_exhibicion, $descripcion_exhibicion, $id_tanque, $id);
        if ($stmt->execute()) {
            $msg = "Exhibición actualizada correctamente.";
            // Refrescar datos
            $sql = "SELECT * FROM exhibiciones WHERE id_exhibicion=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $exhibicion = $result->fetch_assoc();
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
    <title>Editar Exhibición</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Exhibición</h2>
<form method="post">
    Fecha Exhibición: <input type="date" name="fecha_exhibicion" value="<?= $exhibicion['fecha_exhibicion'] ?>" required><br>
    Lugar Exhibición: <input type="text" name="lugar_exhibicion" maxlength="100" value="<?= htmlspecialchars($exhibicion['lugar_exhibicion']) ?>" required><br>
    Descripción: <input type="text" name="descripcion_exhibicion" maxlength="255" value="<?= htmlspecialchars($exhibicion['descripcion_exhibicion']) ?>" required><br>
    Tanque (opcional): 
    <select name="id_tanque">
        <option value="">-- Ninguno --</option>
        <?php while($row = $tq->fetch_assoc()): ?>
            <option value="<?= $row['id_tanque'] ?>" <?= $row['id_tanque'] == $exhibicion['id_tanque'] ? 'selected' : '' ?>>
                <?= $row['id_tanque'] ?>
            </option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>