<?php
include_once "../config.php";
$msg = "";

// Cargar tanques para el select
$tq = $conn->query("SELECT id_tanque FROM tanques");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_exhibicion = $_POST["id_exhibicion"];
    $fecha_exhibicion = $_POST["fecha_exhibicion"];
    $lugar_exhibicion = $_POST["lugar_exhibicion"];
    $descripcion_exhibicion = $_POST["descripcion_exhibicion"];
    $id_tanque = $_POST["id_tanque"] ?: null;

    // Verificar si ya existe exhibición con ese ID
    $check = $conn->prepare("SELECT 1 FROM exhibiciones WHERE id_exhibicion=?");
    $check->bind_param("i", $id_exhibicion);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $msg = "Ya existe una exhibición con ese ID.";
    } else {
        $sql = "INSERT INTO exhibiciones (id_exhibicion, fecha_exhibicion, lugar_exhibicion, descripcion_exhibicion, id_tanque) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssi", $id_exhibicion, $fecha_exhibicion, $lugar_exhibicion, $descripcion_exhibicion, $id_tanque);
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
    ID Exhibición: <input type="number" name="id_exhibicion" required><br>
    Fecha Exhibición: <input type="date" name="fecha_exhibicion" required><br>
    Lugar Exhibición: <input type="text" name="lugar_exhibicion" maxlength="100" required><br>
    Descripción: <input type="text" name="descripcion_exhibicion" maxlength="255" required><br>
    Tanque: 
    <select name="id_tanque" required>
        <option value="">-- Ninguno --</option>
        <?php while($row = $tq->fetch_assoc()): ?>
            <option value="<?= $row['id_tanque'] ?>"><?= $row['id_tanque'] ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>