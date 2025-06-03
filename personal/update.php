<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM personal WHERE id_personal=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $personal = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_personal = $_POST["nombre_personal"];
        $puesto = $_POST["puesto"];
        $num_tel = $_POST["num_tel"];

        $sql = "UPDATE personal SET nombre_personal=?, puesto=?, num_tel=? WHERE id_personal=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $nombre_personal, $puesto, $num_tel, $id);
        if ($stmt->execute()) {
            $msg = "Personal actualizado correctamente.";
            // Refrescar datos
            $sql = "SELECT * FROM personal WHERE id_personal=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $personal = $result->fetch_assoc();
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
    <title>Editar Personal</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Personal</h2>
<form method="post">
    Nombre: <input type="text" name="nombre_personal" value="<?= htmlspecialchars($personal['nombre_personal']) ?>" required><br>
    Puesto: <input type="text" name="puesto" value="<?= htmlspecialchars($personal['puesto']) ?>" required><br>
    Teléfono: <input type="number" name="num_tel" value="<?= $personal['num_tel'] ?>"><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>