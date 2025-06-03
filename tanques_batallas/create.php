<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_TB"];
    $id_tanque = $_POST["id_tanque"];
    $id_batalla = $_POST["id_batalla"];
    $sql = "INSERT INTO tanques_batallas (id_TB, id_tanque, id_batalla) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id, $id_tanque, $id_batalla);
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
    ID Relación: <input type="number" name="id_TB" required> <br>
    ID Tanque: 
    <select name="id_tanque" required>
        <option value="">--Selecciona un tanque--</option>
        <?php
        $result = $conn->query("SELECT id_tanque FROM tanques");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_tanque'] . "'>" . $row['id_tanque'] . "</option>";
        }
        ?>
    </select><br>
    ID Batalla: 
    <select name="id_batalla" required>
        <option value="">--Selecciona una batalla--</option>
        <?php
        $result = $conn->query("SELECT id_batalla FROM batallas");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_batalla'] . "'>" . $row['id_batalla'] . "</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>