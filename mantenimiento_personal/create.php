<!-- Se utiliza JavaScript para manejar la creación de relaciones entre mantenimientos y personal.
// Se utiliza AJAX para cargar los mantenimientos de un tanque seleccionado.
// Este script permite seleccionar un tanque, mostrar sus mantenimientos y crear una relación con el personal.
// Este script maneja la creación de relaciones entre mantenimientos y personal.-->
<?php
include_once "../config.php";
$msg = "";

// AJAX: Si recibe GET con un id_tanque, muestra solo la tabla de mantenimientos filtrada (igual que mantenimientos/read.php)
if (isset($_GET['ajax']) && $_GET['ajax'] === 'mantenimientos' && isset($_GET['id_tanque'])) {
    $id_tanque = intval($_GET['id_tanque']);
    $sql = "SELECT m.*, t.nombre_tanque FROM mantenimientos m JOIN tanques t ON m.id_tanque = t.id_tanque WHERE m.id_tanque = $id_tanque ORDER BY m.id_mantenimiento";
    $result = $conn->query($sql);
    ?>
    <table>
        <tr>
            <th>ID</th>
            <th>ID Tanque</th>
            <th>Nombre Tanque</th>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Notas</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_mantenimiento'] ?></td>
            <td><?= $row['id_tanque'] ?></td>
            <td><?= htmlspecialchars($row['nombre_tanque']) ?></td>
            <td><?= $row['fecha_mantenimiento'] ?></td>
            <td><?= $row['tipo_mantenimiento'] ?></td>
            <td><?= $row['notas'] ?></td>
            <td>
                <a href="../mantenimientos/update.php?id=<?= $row['id_mantenimiento'] ?>">Editar</a> |
                <a href="../mantenimientos/delete.php?id=<?= $row['id_mantenimiento'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este mantenimiento?')">Eliminar</a> |
                <button type="button" class="seleccionar-mantenimiento" data-id="<?= $row['id_mantenimiento'] ?>">Seleccionar</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php
    exit;
}
// Si es POST, procesa la creación de la relación mantenimiento-personal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_mantenimiento"], $_POST["id_personal"])) {
    $idm = $_POST["id_mantenimiento"];
    $idp = $_POST["id_personal"];
    $sql = "INSERT INTO mantenimiento_personal (id_mantenimiento, id_personal) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idm, $idp);
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
    <title>Crear Mantenimiento Personal</title>
    <link rel="stylesheet" href="../estilos.css">
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var tanqueSelect = document.getElementById('id_tanque');
        var tablaDiv = document.getElementById('tabla-mantenimientos');
        var idMantenimientoInput = document.getElementById('id_mantenimiento');

        tanqueSelect.addEventListener('change', function() {
            var idTanque = this.value;
            tablaDiv.innerHTML = '';
            idMantenimientoInput.value = '';
            if (idTanque) {
                fetch('create.php?ajax=mantenimientos&id_tanque=' + idTanque)
                    .then(response => response.text())
                    .then(html => {
                        tablaDiv.innerHTML = html;
                        tablaDiv.querySelectorAll('.seleccionar-mantenimiento').forEach(function(btn) {
                            btn.addEventListener('click', function() {
                                idMantenimientoInput.value = this.getAttribute('data-id');
                                // Resalta la fila seleccionada
                                tablaDiv.querySelectorAll('tr').forEach(tr => tr.classList.remove('seleccionado'));
                                btn.closest('tr').classList.add('seleccionado');
                            });
                        });
                    });
            }
        });
    });
    </script>
    <style>
    .seleccionado { background: #e0ffe0; }
    </style>
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear Relación Mantenimiento-Personal</h2>
<form method="post">
    Tanque al que se le realizó el mantenimiento:
    <select name="id_tanque" id="id_tanque" required>
        <option value="">--Selecciona un tanque--</option>
        <?php
        $result = $conn->query("SELECT id_tanque, nombre_tanque FROM tanques");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_tanque'] . "'>" . htmlspecialchars($row['nombre_tanque']) . "</option>";
        }
        ?>
    </select><br><br>
    <input type="hidden" name="id_mantenimiento" id="id_mantenimiento" value="" required>
    <div id="tabla-mantenimientos"></div>
    <br>
    Personal:
    <select name="id_personal" required>
        <option value="">--Selecciona un personal--</option>
        <?php
        $result = $conn->query("SELECT id_personal, nombre_personal FROM personal");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_personal'] . "'>" . htmlspecialchars($row['nombre_personal']) . "</option>";
        }
        ?>
    </select><br><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>