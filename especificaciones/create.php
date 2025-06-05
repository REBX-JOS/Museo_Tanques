<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tanque = $_POST["id_tanque"];
    $peso_toneladas = $_POST["peso_toneladas"];
    $longitud_metros = $_POST["longitud_metros"];
    $blindaje_mm = $_POST["blindaje_mm"];
    $velocidad_kmh = $_POST["velocidad_kmh"];
    $armamento_principal = $_POST["armamento_principal"];

    // Verificar si ya existe una especificación para ese tanque
    $sql_check_spec = "SELECT 1 FROM especificaciones WHERE id_tanque = ?";
    $stmt_check_spec = $conn->prepare($sql_check_spec);
    $stmt_check_spec->bind_param("i", $id_tanque);
    $stmt_check_spec->execute();
    $stmt_check_spec->store_result();
    if ($stmt_check_spec->num_rows > 0) {
        $msg = "¡Ya existe una especificación para el tanque seleccionado!";
    } else {
        // Insertar la especificación (NO INSERTES id de especificación, solo el id_tanque)
        $sql = "INSERT INTO especificaciones 
            (id_tanque, peso_toneladas, longitud_metros, blindaje_mm, velocidad_kmh, armamento_principal)
            VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iddids", $id_tanque, $peso_toneladas, $longitud_metros, $blindaje_mm, $velocidad_kmh, $armamento_principal);
        if ($stmt->execute()) {
            $msg = "Especificación creada correctamente.";
        } else {
            $msg = "Error al crear la especificación: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Especificación</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Especificación</h2>
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
    </select><br>
    Peso (toneladas): <input type="number" step="0.01" name="peso_toneladas" required><br>
    Longitud (metros): <input type="number" step="0.01" name="longitud_metros" required><br>
    Blindaje (mm): <input type="number" name="blindaje_mm" required><br>
    Velocidad (km/h): <input type="number" step="0.01" name="velocidad_kmh" required><br>
    Armamento principal: <input type="text" name="armamento_principal" maxlength="100" required><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>