<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null; // id_TB de la tabla tanques_batallas

if ($id) {
    // Obtener la relación actual por id_TB
    $sql = "SELECT tb.*, t.id_tanque, t.nombre_tanque, b.id_batalla, b.nombre_batalla
            FROM tanques_batallas tb
            JOIN tanques t ON tb.id_tanque = t.id_tanque
            JOIN batallas b ON tb.id_batalla = b.id_batalla
            WHERE tb.id_TB = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $relacion = $stmt->get_result()->fetch_assoc();

    // Cargar tanques (por id y nombre)
    $tanques = [];
    $result = $conn->query("SELECT id_tanque, nombre_tanque FROM tanques");
    while ($row = $result->fetch_assoc()) {
        $tanques[] = $row;
    }
    // Cargar batallas (por id y nombre)
    $batallas = [];
    $result = $conn->query("SELECT id_batalla, nombre_batalla FROM batallas");
    while ($row = $result->fetch_assoc()) {
        $batallas[] = $row;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nuevo_id_tanque = $_POST["id_tanque"];
        $nuevo_id_batalla = $_POST["id_batalla"];

        // Actualizar la relación
        $sql = "UPDATE tanques_batallas SET id_tanque=?, id_batalla=? WHERE id_TB=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $nuevo_id_tanque, $nuevo_id_batalla, $id);
        if ($stmt->execute()) {
            $msg = "Relación actualizada correctamente.";
            // Refrescar datos
            $sql = "SELECT tb.*, t.id_tanque, t.nombre_tanque, b.id_batalla, b.nombre_batalla
                    FROM tanques_batallas tb
                    JOIN tanques t ON tb.id_tanque = t.id_tanque
                    JOIN batallas b ON tb.id_batalla = b.id_batalla
                    WHERE tb.id_TB = ?";
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
<h2>Editar Relación Tanque-Batalla</h2>
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