<?php
include_once "config.php";
$msg = "";
$resultados = [];

// 1. Cargar países para el select
$paises = $conn->query("SELECT id_pais, nombre_pais FROM paises");

// 2. Al enviar el formulario:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pais = $_POST["id_pais"];

    // Llamar al procedimiento almacenado
    $stmt = $conn->prepare("CALL ConsultarTanquesPorPais(?)");
    $stmt->bind_param("i", $id_pais);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $resultados[] = $row;
            }
        } else {
            $msg = "No se encontraron tanques para ese país.";
        }
        $res->free();
    } else {
        $msg = "Error al ejecutar el procedimiento: " . $conn->error;
    }
    $stmt->close();
    $conn->next_result();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Consultar Tanques por País</title>
    <link rel="stylesheet" href="/museotanques/estilos.css">
</head>
<body>
<?php include "menu.php"; ?>
<h2>Consultar Tanques por País</h2>
<form method="post">
    <label>Selecciona un país:</label>
    <select name="id_pais" required>
        <option value="">--Selecciona--</option>
        <?php while($pais = $paises->fetch_assoc()): ?>
            <option value="<?= $pais['id_pais'] ?>" <?= isset($id_pais) && $id_pais == $pais['id_pais'] ? "selected" : "" ?>>
                <?= htmlspecialchars($pais['nombre_pais']) ?>
            </option>
        <?php endwhile; ?>
    </select>
    <input type="submit" value="Consultar">
</form>
<p><?= $msg ?></p>

<?php if ($resultados): ?>
    <h3>Tanques del país seleccionado:</h3>
    <table border="1">
        <tr>
            <th>Nombre Tanque</th>
            <th>Modelo</th>
            <th>Nombre País</th>
        </tr>
        <?php foreach($resultados as $fila): ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre_tanque']) ?></td>
                <td><?= htmlspecialchars($fila['modelo']) ?></td>
                <td><?= htmlspecialchars($fila['nombre_pais']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?> <br>
<form> <input type="submit" value="Regresar" formaction="read.php" formnovalidate> </form>
</body>
</html>