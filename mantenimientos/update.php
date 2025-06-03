<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM mantenimientos WHERE id_mantenimiento=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mantenimiento = $result->fetch_assoc();

    // Cargar tanques para el select
    $tq = $conn->query("SELECT id_tanque FROM tanques");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_tanque = $_POST["id_tanque"] ?: null;
        $fecha_mantenimiento = $_POST["fecha_mantenimiento"];
        $tipo_mantenimiento = $_POST["tipo_mantenimiento"];
        $notas = $_POST["notas"];

        $sql = "UPDATE mantenimientos SET id_tanque=?, fecha_mantenimiento=?, tipo_mantenimiento=?, notas=? WHERE id_mantenimiento=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssi", $id_tanque, $fecha_mantenimiento, $tipo_mantenimiento, $notas, $id);
        if ($stmt->execute()) {
            $msg = "Mantenimiento actualizado correctamente.";
            // Refrescar datos
            $sql = "SELECT * FROM mantenimientos WHERE id_mantenimiento=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $mantenimiento = $result->fetch_assoc();
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
    <title>Editar Mantenimiento</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Mantenimiento</h2>
<form method="post">
    Tanque: 
    <select name="id_tanque" required>
        <option value="">--Selecciona un tanque--</option>
        <?php while($row = $tq->fetch_assoc()): ?>
            <option value="<?= $row['id_tanque'] ?>" <?= $row['id_tanque'] == $mantenimiento['id_tanque'] ? 'selected' : '' ?>>
                <?= $row['id_tanque'] ?>
            </option>
        <?php endwhile; ?>
    </select><br>
    Fecha Mantenimiento: <input type="datetime-local" name="fecha_mantenimiento" value="<?= date('Y-m-d\TH:i', strtotime($mantenimiento['fecha_mantenimiento'])) ?>" required><br>
    Tipo de Mantenimiento:
        <input type="radio" name="tipo_mantenimiento" value="preventivo" checked> Preventivo
        <input type="radio" name="tipo_mantenimiento" value="correctivo"> Correctivo<br>
    Notas: <input type="text" name="notas" maxlength="255" value="<?= htmlspecialchars($mantenimiento['notas']) ?>"><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>