<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tanque = $_POST["id_tanque"];
    $id_batalla = $_POST["id_batalla"];
    $sql = "INSERT INTO tanques_batallas (id_tanque, id_batalla) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_tanque, $id_batalla);
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
    <title>Crear Tanque-Batalla</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Relación Tanque-Batalla</h2>
<form method="post">
    Tanque:
    <select name="id_tanque" required>
        <option value="">--Selecciona un tanque--</option>
        <?php
        $result = $conn->query("SELECT id_tanque, nombre_tanque FROM tanques");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_tanque'] . "'>" . htmlspecialchars($row['nombre_tanque']) . "</option>";
        }
        ?>
    </select><br><br>
    Batalla:
    <select name="id_batalla" required>
        <option value="">--Selecciona una batalla--</option>
        <?php
        $result = $conn->query("SELECT id_batalla, nombre_batalla FROM batallas");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_batalla'] . "'>" . htmlspecialchars($row['nombre_batalla']) . "</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>