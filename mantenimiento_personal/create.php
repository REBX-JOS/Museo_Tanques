<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idm = $_POST["id_mantenimiento"];
    $idp = $_POST["id_personal"];
    $sql = "INSERT INTO mantenimiento_personal (id_mantenimiento, id_personal) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idm, $idp);
    if ($stmt->execute()) {
        $msg = "Relación creada correctamente.";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Mantenimiento Personal</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Relación Mantenimiento-Personal</h2>
<form method="post">
    Mantenimiento: 
    <select name="id_mantenimiento" required>
        <option value="">--Selecciona un mantenimiento--</option>
        <?php
        $result = $conn->query("SELECT id_mantenimiento FROM mantenimientos");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_mantenimiento'] . "'>" . $row['id_mantenimiento'] . "</option>";
        }
        ?>
    </select><br><br>
    Personal: 
    <select name="id_personal" required>
        <option value="">--Selecciona un personal--</option>
        <?php
        $result = $conn->query("SELECT id_personal, nombre_personal FROM personal");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_personal'] . "'>" . htmlspecialchars($row['nombre_personal']) . "</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>