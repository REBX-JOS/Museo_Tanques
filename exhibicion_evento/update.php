<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;

if ($id) {
    // Obtener la relación actual
    $sql = "SELECT * FROM exhibicion_evento WHERE id_EVEX=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $relacion = $stmt->get_result()->fetch_assoc();

    // Obtener todas las exhibiciones
    $exhibiciones = [];
    $result = $conn->query("SELECT id_exhibicion, nombre_ex FROM exhibiciones");
    while ($row = $result->fetch_assoc()) {
        $exhibiciones[] = $row;
    }
    // Obtener todos los eventos
    $eventos = [];
    $result = $conn->query("SELECT id_evento, nombre_evento FROM eventos");
    while ($row = $result->fetch_assoc()) {
        $eventos[] = $row;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_exhibicion = $_POST["id_exhibicion"];
        $id_evento = $_POST["id_evento"];
        $sql = "UPDATE exhibicion_evento SET id_exhibicion=?, id_evento=? WHERE id_EVEX=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $id_exhibicion, $id_evento, $id);
        if ($stmt->execute()) {
            $msg = "Relación actualizada correctamente.";
            // Volver a cargar los datos actualizados
            $sql = "SELECT * FROM exhibicion_evento WHERE id_EVEX=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $relacion = $stmt->get_result()->fetch_assoc();
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
    <title>Editar Exhibición-Evento</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Relación Exhibición-Evento</h2>
<form method="post">
    Exhibición:
    <select name="id_exhibicion" required>
        <option value="">--Selecciona una exhibición--</option>
        <?php foreach ($exhibiciones as $exh): ?>
            <option value="<?= $exh['id_exhibicion'] ?>"
                <?= ($relacion['id_exhibicion'] == $exh['id_exhibicion']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($exh['nombre_ex']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    Evento:
    <select name="id_evento" required>
        <option value="">--Selecciona un evento--</option>
        <?php foreach ($eventos as $evt): ?>
            <option value="<?= $evt['id_evento'] ?>"
                <?= ($relacion['id_evento'] == $evt['id_evento']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($evt['nombre_evento']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>