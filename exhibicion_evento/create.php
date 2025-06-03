<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_EVEX"];
    $id_exhibicion = $_POST["id_exhibicion"];
    $id_evento = $_POST["id_evento"];
    $sql = "INSERT INTO exhibicion_evento (id_EVEX, id_exhibicion, id_evento) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id, $id_exhibicion, $id_evento);
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
    <title>Crear Exhibición-Evento</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Relación Exhibición-Evento</h2>
<form method="post">
    ID Relación: <input type="number" name="id_EVEX" required>
    </select><br>
    ID Exhibición:
    <select name="id_exhibicion" required>
        <option value="">--Selecciona una exhibición--</option>
        <?php
        $result = $conn->query("SELECT id_exhibicion FROM exhibiciones");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_exhibicion'] . "'>" . $row['id_exhibicion'] . "</option>";
        }
        ?>
    </select><br>
    ID Evento:
    <select name="id_evento" required>
        <option value="">--Selecciona un evento--</option>
        <?php
        $result = $conn->query("SELECT id_evento FROM eventos");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_evento'] . "'>" . $row['id_evento'] . "</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>