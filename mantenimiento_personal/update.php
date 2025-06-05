<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    // Obtener la relación actual
    $sql = "SELECT * FROM mantenimiento_personal WHERE id_MP=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $relacion = $stmt->get_result()->fetch_assoc();

    // Cargar mantenimientos y personal para los select
    $mantenimientos = [];
    $result = $conn->query("SELECT id_mantenimiento, id_mantenimiento FROM mantenimientos");
    while ($row = $result->fetch_assoc()) {
        $mantenimientos[] = $row;
    }
    $personal = [];
    $result = $conn->query("SELECT id_personal, nombre_personal FROM personal");
    while ($row = $result->fetch_assoc()) {
        $personal[] = $row;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idm = $_POST["id_mantenimiento"];
        $idp = $_POST["id_personal"];
        $sql = "UPDATE mantenimiento_personal SET id_mantenimiento=?, id_personal=? WHERE id_MP=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $idm, $idp, $id);
        if ($stmt->execute()) {
            $msg = "Relacion actualizada correctamente.";
            // Recargar datos actualizados
            $sql = "SELECT * FROM mantenimiento_personal WHERE id_MP=?";
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
    <title>Editar Mantenimiento Personal</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Relacion Mantenimiento-Personal</h2>
<form method="post">
    Mantenimiento:
    <select name="id_mantenimiento" required>
        <option value="">--Selecciona un mantenimiento--</option>
        <?php foreach ($mantenimientos as $mnt): ?>
            <option value="<?= $mnt['id_mantenimiento'] ?>" <?= ($relacion['id_mantenimiento'] == $mnt['id_mantenimiento']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($mnt['id_mantenimiento']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    Personal:
    <select name="id_personal" required>
        <option value="">--Selecciona personal--</option>
        <?php foreach ($personal as $per): ?>
            <option value="<?= $per['id_personal'] ?>" <?= ($relacion['id_personal'] == $per['id_personal']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($per['nombre_personal']) ?>
            </option>
        <?php endforeach; ?>
    </select><br> <br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>