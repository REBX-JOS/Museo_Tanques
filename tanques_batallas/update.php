<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    // Obtener la relación actual
    $sql = "SELECT * FROM tanques_batallas WHERE id_TB=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $relacion = $stmt->get_result()->fetch_assoc();

    // Cargar tanques y batallas para los select
    $tanques = [];
    $result = $conn->query("SELECT id_tanque, nombre_tanque FROM tanques");
    while ($row = $result->fetch_assoc()) {
        $tanques[] = $row;
    }
    $batallas = [];
    $result = $conn->query("SELECT id_batalla, nombre_batalla FROM batallas");
    while ($row = $result->fetch_assoc()) {
        $batallas[] = $row;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_tanque = $_POST["id_tanque"];
        $id_batalla = $_POST["id_batalla"];
        $sql = "UPDATE tanques_batallas SET id_tanque=?, id_batalla=? WHERE id_TB=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $id_tanque, $id_batalla, $id);
        if ($stmt->execute()) {
            $msg = "Relacion actualizada correctamente.";
            // Recargar datos actualizados
            $sql = "SELECT * FROM tanques_batallas WHERE id_TB=?";
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
    <title>Editar Tanque-Batalla</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Relacion Tanque-Batalla</h2>
<form method="post">
    Tanque:
    <select name="id_tanque" required>
        <option value="">--Selecciona un tanque--</option>
        <?php foreach ($tanques as $tanque): ?>
            <option value="<?= $tanque['id_tanque'] ?>" <?= ($relacion['id_tanque'] == $tanque['id_tanque']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($tanque['nombre_tanque']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    Batalla:
    <select name="id_batalla" required>
        <option value="">--Selecciona una batalla--</option>
        <?php foreach ($batallas as $batalla): ?>
            <option value="<?= $batalla['id_batalla'] ?>" <?= ($relacion['id_batalla'] == $batalla['id_batalla']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($batalla['nombre_batalla']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>