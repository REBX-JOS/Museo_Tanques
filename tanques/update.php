<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM tanques WHERE id_tanque=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tanque = $result->fetch_assoc();

    // Cargar países para el select
    $paises = $conn->query("SELECT id_pais, nombre_pais FROM paises");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $modelo = $_POST["modelo"];
        $nuevo_nombre_tanque = $_POST["nombre_tanque"];
        $tipo_tanque = $_POST["tipo_tanque"];
        $anio_fabricacion = $_POST["anio_fabricacion"];
        $id_pais = $_POST["id_pais"] ?: null;

        $sql = "UPDATE tanques SET modelo=?, nombre_tanque=?, tipo_tanque=?, anio_fabricacion=?, id_pais=? WHERE id_tanque=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiii", $modelo, $nuevo_nombre_tanque, $tipo_tanque, $anio_fabricacion, $id_pais, $id);
        if ($stmt->execute()) {
            $msg = "Tanque actualizado correctamente.";
            // Refrescar datos
            $sql = "SELECT * FROM tanques WHERE id_tanque=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $tanque = $result->fetch_assoc();
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
    <title>Editar Tanque</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Tanque</h2>
<form method="post">
    Modelo: <input type="text" name="modelo" value="<?= htmlspecialchars($tanque['modelo']) ?>" required><br>
    Nombre: <input type="text" name="nombre_tanque" value="<?= htmlspecialchars($tanque['nombre_tanque']) ?>" required><br>
    Tipo: <input type="text" name="tipo_tanque" value="<?= htmlspecialchars($tanque['tipo_tanque']) ?>" required><br>
    Año Fabricación: <input type="number" name="anio_fabricacion" value="<?= $tanque['anio_fabricacion'] ?>"><br>
    País: 
    <select name="id_pais" required>
        <option value="">--Selecciona País--</option>
        <?php while($row = $paises->fetch_assoc()): ?>
            <option value="<?= $row['id_pais'] ?>" <?= $row['id_pais'] == $tanque['id_pais'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['nombre_pais']) ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>