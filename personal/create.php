<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_personal = $_POST["nombre_personal"];
    $puesto = $_POST["puesto"];
    $num_tel = $_POST["num_tel"];

    // Verificar si ya existe personal con el mismo nombre y puesto (puedes modificar la lógica de unicidad si lo deseas)
    $check = $conn->prepare("SELECT 1 FROM personal WHERE nombre_personal = ? AND puesto = ?");
    $check->bind_param("ss", $nombre_personal, $puesto);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $msg = "Ya existe un registro con ese nombre y puesto.";
    } else {
        $sql = "INSERT INTO personal (nombre_personal, puesto, num_tel) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nombre_personal, $puesto, $num_tel);
        if ($stmt->execute()) {
            $msg = "Personal creado correctamente.";
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
    <title>Crear Personal</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Personal</h2>
<form method="post">
    Nombre: <input type="text" name="nombre_personal" required><br>
    Puesto: <input type="text" name="puesto" required><br>
    Teléfono: <input type="number" name="num_tel"><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>