<?php
include_once "../config.php";
$msg = "";

// Cargar países para el select
$paises = $conn->query("SELECT id_pais, nombre_pais FROM paises");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = $_POST["modelo"];
    $nombre_tanque = $_POST["nombre_tanque"];
    $tipo_tanque = $_POST["tipo_tanque"];
    $anio_fabricacion = $_POST["anio_fabricacion"];
    $id_pais = $_POST["id_pais"] ?: null;

    // Verificar si ya existe el tanque con ese nombre y modelo (puedes cambiar la lógica según tu caso)
    $check = $conn->prepare("SELECT 1 FROM tanques WHERE nombre_tanque = ? AND modelo = ?");
    $check->bind_param("ss", $nombre_tanque, $modelo);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $msg = "Ya existe un tanque con ese nombre y modelo.";
    } else {
        $sql = "INSERT INTO tanques (modelo, nombre_tanque, tipo_tanque, anio_fabricacion, id_pais) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $modelo, $nombre_tanque, $tipo_tanque, $anio_fabricacion, $id_pais);
        if ($stmt->execute()) {
            $msg = "Tanque creado correctamente.";
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Tanque</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Tanque</h2>
<form method="post">
    Modelo: <input type="text" name="modelo" required><br>
    Nombre: <input type="text" name="nombre_tanque" required><br>
    Tipo: <input type="text" name="tipo_tanque" required><br>
    Año Fabricación: <input type="number" name="anio_fabricacion"><br>
    País: 
    <select name="id_pais" required>
        <option value="">--Selecciona País--</option>
        <?php while($row = $paises->fetch_assoc()): ?>
            <option value="<?= $row['id_pais'] ?>"><?= htmlspecialchars($row['nombre_pais']) ?></option>
        <?php endwhile; ?>
    </select><br><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>