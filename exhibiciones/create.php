<?php
include_once "../config.php";
$msg = "";

// Cargar tanques para el select (traer id y nombre)
$tq = $conn->query("SELECT id_tanque, nombre_tanque FROM tanques");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_exhibicion = $_POST["fecha_exhibicion"];
    $nombre_exhibicion = $_POST["nombre_ex"] ?: null; 
    $lugar_exhibicion = $_POST["lugar_exhibicion"];
    $descripcion_exhibicion = $_POST["descripcion_exhibicion"];
    $id_tanque = $_POST["id_tanque"] ?: null;

    // Verificar si ya existe exhibición con la misma fecha y tanque en el mismo lugar
    $check = $conn->prepare("SELECT 1 FROM exhibiciones WHERE fecha_exhibicion=? AND id_tanque=? AND lugar_exhibicion=?");
    $check->bind_param("sis", $fecha_exhibicion, $id_tanque, $lugar_exhibicion);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $msg = "Ya existe una exhibición con ese tanque en esa fecha y lugar.";
    } else {
        $sql = "INSERT INTO exhibiciones (fecha_exhibicion, nombre_ex, lugar_exhibicion, descripcion_exhibicion, id_tanque) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $fecha_exhibicion, $nombre_exhibicion, $lugar_exhibicion, $descripcion_exhibicion, $id_tanque);
        if ($stmt->execute()) {
            $msg = "Exhibición creada correctamente.";
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
    <title>Crear Exhibición</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Exhibición</h2>
<form method="post">
    Fecha Exhibición: <input type="date" name="fecha_exhibicion" required><br>
    Nombre Exhibición: <input type="text" name="nombre_ex" maxlength="100" required><br>
    Lugar Exhibición: <input type="text" name="lugar_exhibicion" maxlength="100" required><br>
    Descripción: <input type="text" name="descripcion_exhibicion" maxlength="255" required><br>
    Tanque: 
    <select name="id_tanque" required>
        <option value="">-- Selecciona un tanque --</option>
        <?php while($row = $tq->fetch_assoc()): ?>
            <option value="<?= $row['id_tanque'] ?>"><?= htmlspecialchars($row['nombre_tanque']) ?></option>
        <?php endwhile; ?>
    </select><br><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>