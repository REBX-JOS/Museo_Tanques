<?php
include_once "../config.php";
$msg = "";

// Cambia la consulta para obtener id y nombre
$tq = $conn->query("SELECT id_tanque, nombre_tanque FROM tanques");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tanque = $_POST["id_tanque"] ?: null;
    $fecha_mantenimiento = $_POST["fecha_mantenimiento"];
    $tipo_mantenimiento = $_POST["tipo_mantenimiento"];
    $notas = $_POST["notas"];

    $sql = "INSERT INTO mantenimientos (id_tanque, fecha_mantenimiento, tipo_mantenimiento, notas) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $id_tanque, $fecha_mantenimiento, $tipo_mantenimiento, $notas);
    if ($stmt->execute()) {
        $msg = "Mantenimiento creado correctamente.";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Mantenimiento</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Mantenimiento</h2>
<form method="post">
    Tanque: 
    <select name="id_tanque" required>
        <option value="">--Selecciona un tanque--</option>
        <?php while($row = $tq->fetch_assoc()): ?>
            <option value="<?= $row['id_tanque'] ?>"><?= htmlspecialchars($row['nombre_tanque']) ?></option>
        <?php endwhile; ?>
    </select><br>
    Fecha Mantenimiento: <input type="datetime-local" name="fecha_mantenimiento" required><br>
    Tipo de Mantenimiento: 
        <input type="radio" name="tipo_mantenimiento" value="Preventivo" checked> Preventivo
        <input type="radio" name="tipo_mantenimiento" value="Correctivo" > Correctivo<br>
    Notas: <input type="text" name="notas" maxlength="255"><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>