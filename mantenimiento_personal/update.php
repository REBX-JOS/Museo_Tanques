<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null; // id_MP

if ($id) {
    // Obtener la relación actual y sus detalles relacionados
    $sql = "SELECT mp.*, m.id_mantenimiento, m.tipo_mantenimiento, m.fecha_mantenimiento, m.id_tanque, t.nombre_tanque, p.id_personal, p.nombre_personal
            FROM mantenimiento_personal mp
            JOIN mantenimientos m ON mp.id_mantenimiento = m.id_mantenimiento
            JOIN tanques t ON m.id_tanque = t.id_tanque
            JOIN personal p ON mp.id_personal = p.id_personal
            WHERE mp.id_MP = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $relacion = $stmt->get_result()->fetch_assoc();

    // Cargar tanques para el select
    $tanques = [];
    $result = $conn->query("SELECT id_tanque, nombre_tanque FROM tanques");
    while ($row = $result->fetch_assoc()) {
        $tanques[] = $row;
    }
    // Cargar personal (listar todos)
    $personal_lista = [];
    $result = $conn->query("SELECT id_personal, nombre_personal FROM personal");
    while ($row = $result->fetch_assoc()) {
        $personal_lista[] = $row;
    }

    // Para recarga por AJAX
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
                    <button type="button" class="seleccionar-mantenimiento" data-id="<?= $row['id_mantenimiento'] ?>">Seleccionar</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
        $nuevo_id_tanque = $_POST["id_tanque"];
        $nuevo_id_mantenimiento = $_POST["id_mantenimiento"];
        $nuevo_id_personal = $_POST["id_personal"];

        // Actualizar la relación
        $sql = "UPDATE mantenimiento_personal SET id_mantenimiento=?, id_personal=? WHERE id_MP=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $nuevo_id_mantenimiento, $nuevo_id_personal, $id);
        if ($stmt->execute()) {
            $msg = "Relación actualizada correctamente.";
            // Refrescar datos
            $sql = "SELECT mp.*, m.id_mantenimiento, m.tipo_mantenimiento, m.fecha_mantenimiento, m.id_tanque, t.nombre_tanque, p.id_personal, p.nombre_personal
                    FROM mantenimiento_personal mp
                    JOIN mantenimientos m ON mp.id_mantenimiento = m.id_mantenimiento
                    JOIN tanques t ON m.id_tanque = t.id_tanque
                    JOIN personal p ON mp.id_personal = p.id_personal
                    WHERE mp.id_MP = ?";
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
    <title>Editar Relación Mantenimiento-Personal</title>
    <link rel="stylesheet" href="../estilos.css">
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var tanqueSelect = document.getElementById('id_tanque');
        var tablaDiv = document.getElementById('tabla-mantenimientos');
        var idMantenimientoInput = document.getElementById('id_mantenimiento');

        function cargarTablaMantenimientos(idTanque, mantenimientoActual) {
            tablaDiv.innerHTML = '';
            idMantenimientoInput.value = '';
            if (idTanque) {
                fetch('update.php?ajax=mantenimientos&id=<?= $id ?>&id_tanque=' + idTanque)
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
                        // Si hay mantenimiento actual, resáltalo
                        if(mantenimientoActual) {
                            tablaDiv.querySelectorAll('.seleccionar-mantenimiento').forEach(function(btn) {
                                if(btn.getAttribute('data-id') == mantenimientoActual) {
                                    btn.closest('tr').classList.add('seleccionado');
                                    idMantenimientoInput.value = mantenimientoActual;
                                }
                            });
                        }
                    });
            }
        }

        // Cargar tabla al cambiar el tanque
        tanqueSelect.addEventListener('change', function() {
            cargarTablaMantenimientos(this.value, null);
        });

        // Cargar tabla inicial con el mantenimiento actual ya seleccionado
        cargarTablaMantenimientos(tanqueSelect.value, "<?= $relacion['id_mantenimiento'] ?>");
    });
    </script>
    <style>
    .seleccionado { background: #e0ffe0; }
    </style>
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Relación Mantenimiento-Personal</h2>
<form method="post" id="form-mp">
    Tanque:
    <select name="id_tanque" id="id_tanque" required>
        <option value="">--Selecciona un tanque--</option>
        <?php foreach ($tanques as $t): ?>
            <option value="<?= $t['id_tanque'] ?>" <?= ($relacion['id_tanque'] == $t['id_tanque']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($t['nombre_tanque']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <input type="hidden" name="id_mantenimiento" id="id_mantenimiento" value="" required>
    <div id="tabla-mantenimientos"></div>
    <br>
    Personal:
    <select name="id_personal" required>
        <option value="">--Selecciona personal--</option>
        <?php foreach ($personal_lista as $per): ?>
            <option value="<?= $per['id_personal'] ?>" <?= ($relacion['id_personal'] == $per['id_personal']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($per['nombre_personal']) ?>
            </option>
        <?php endforeach; ?>
    </select><br> <br>
    <input type="submit" name="actualizar" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>