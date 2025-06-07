<?php
include_once "config.php";
$id = $_GET['id'] ?? null;
$tabla = $_GET['tabla'] ?? null;

// Inicializa $mensaje para evitar el warning
$mensaje = "";

if (!$id || !$tabla) {
    echo "Falta información.";
    exit;
}

$dependencias = [];
// Definir columnas y archivos de acción para cada relación
$columnas = [];
$acciones = [];

// ... (resto del código igual, sin cambios) ...
// (todo lo que sigue después del bloque de eliminación es igual)

if ($tabla === "tanques") {
    // Exhibiciones relacionadas
    $sql = "SELECT * FROM exhibiciones WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Exhibiciones'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Exhibiciones'] = [
        'ID Exhibición' => 'id_exhibicion',
        'Fecha' => 'fecha_exhibicion',
        'Lugar' => 'lugar_exhibicion',
        'Descripción' => 'descripcion_exhibicion',
    ];
    $acciones['Exhibiciones'] = [
        'edit' => 'exhibiciones/update.php',
        'delete' => 'exhibiciones/delete.php',
        'id' => 'id_exhibicion'
    ];

    // Mantenimientos relacionados
    $sql = "SELECT * FROM mantenimientos WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Mantenimientos'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Mantenimientos'] = [
        'ID Mantenimiento' => 'id_mantenimiento',
        'Fecha' => 'fecha_mantenimiento',
        'Tipo' => 'tipo_mantenimiento',
        'Notas' => 'notas'
    ];
    $acciones['Mantenimientos'] = [
        'edit' => 'mantenimientos/update.php',
        'delete' => 'mantenimientos/delete.php',
        'id' => 'id_mantenimiento'
    ];

    // Tanques_batallas relacionadas
    $sql = "SELECT * FROM tanques_batallas WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Tanques en Batallas'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Tanques en Batallas'] = [
        'ID Relación' => 'id_TB',
        'ID Batalla' => 'id_batalla'
    ];
    $acciones['Tanques en Batallas'] = [
        'edit' => 'tanques_batallas/update.php',
        'delete' => 'tanques_batallas/delete.php',
        'id' => 'id_TB'
    ];

    // Especificaciones relacionadas
    $sql = "SELECT * FROM especificaciones WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Especificaciones'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Especificaciones'] = [
        'ID Especificación' => 'id_tanque',
        'Peso (toneladas)' => 'peso_toneladas',
        'Longitud (metros)' => 'longitud_metros',
        'Blindaje (mm)' => 'blindaje_mm',
        'Velocidad (km/h)' => 'velocidad_kmh',
        'Armamento Principal' => 'armamento_principal'
    ];
    $acciones['Especificaciones'] = [
        'edit' => 'especificaciones/update.php',
        'delete' => 'especificaciones/delete.php',
        'id' => 'id_tanque'
    ];
}

if($tabla === 'exhibiciones') {
    // Exhibicion_evento relacionadas (hijos reales)
    $sql = "SELECT * FROM exhibicion_evento WHERE id_exhibicion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Exhibicion_evento'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Exhibicion_evento'] = [      
        'ID Exhibicion_evento' => 'id_EVEX',
        'ID Exhibición' => 'id_exhibicion',
        'ID Evento' => 'id_evento',
    ];
    $acciones['Exhibicion_evento'] = [
        'edit' => 'exhibicion_evento/update.php',
        'delete' => 'exhibicion_evento/delete.php',
        'id' => 'id_EVEX'
    ];
}

if($tabla === 'mantenimientos') {
    // Mantenimientos_Personal relacionados
    $sql = "SELECT * FROM mantenimiento_personal WHERE id_mantenimiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Mantenimientos_Personal'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Mantenimientos_Personal'] = [
        'ID Relación' => 'id_MP',
        'ID Personal' => 'id_personal'
    ];
    $acciones['Mantenimientos_Personal'] = [
        'edit' => 'mantenimiento_personal/update.php',
        'delete' => 'mantenimiento_personal/delete.php',
        'id' => 'id_MP'
    ];
}

if ($tabla === 'eventos') {
    // Exhibicion_evento relacionadas
    $sql = "SELECT * FROM exhibicion_evento WHERE id_evento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Exhibicion_evento'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Exhibicion_evento'] = [
        'ID Exhibicion_evento' => 'id_EVEX',
        'ID Exhibición' => 'id_exhibicion',
        'ID Evento' => 'id_evento',
    ];
    $acciones['Exhibicion_evento'] = [
        'edit' => 'exhibicion_evento/update.php',
        'delete' => 'exhibicion_evento/delete.php',
        'id' => 'id_EVEX'
    ];
}

if ($tabla === 'batallas') {
    // Tanques_batallas relacionadas
    $sql = "SELECT * FROM tanques_batallas WHERE id_batalla = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Tanques en Batallas'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Tanques en Batallas'] = [
        'ID Relación' => 'id_TB',
        'ID Tanque' => 'id_tanque'
    ];
    $acciones['Tanques en Batallas'] = [
        'edit' => 'tanques_batallas/update.php',
        'delete' => 'tanques_batallas/delete.php',
        'id' => 'id_TB'
    ];
}

if($tabla === 'paises') {
    // Tanques relacionados
    $sql = "SELECT * FROM tanques WHERE id_pais = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Tanques'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Tanques'] = [
        'ID Tanque' => 'id_tanque',
        'Modelo' => 'modelo',
        'Nombre' => 'nombre_tanque',
        'Tipo' => 'tipo_tanque',
        'Año' => 'anio_fabricacion',
        'Pais' => 'id_pais',
    ];
    $acciones['Tanques'] = [
        'edit' => 'tanques/update.php',
        'delete' => 'tanques/delete.php',
        'id' => 'id_tanque'
    ];
}

if ($tabla === "personal") {
    // Relación mantenimiento_personal
    $sql = "SELECT * FROM mantenimiento_personal WHERE id_personal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Mantenimiento Personal'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Mantenimiento Personal'] = [
        'ID Relación' => 'id_MP',
        'ID Mantenimiento' => 'id_mantenimiento'
    ];
    $acciones['Mantenimiento Personal'] = [
        'edit' => 'mantenimiento_personal/update.php',
        'delete' => 'mantenimiento_personal/delete.php',
        'id' => 'id_MP'
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['on_cascade'])) {

    // Eliminar en tanques en cascada
    if ($tabla === "tanques") {
    // 1. Borrar mantenimiento_personal de los mantenimientos de este tanque
    $sql = "SELECT id_mantenimiento FROM mantenimientos WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $id_mant = $row['id_mantenimiento'];
        $sql_mp = "DELETE FROM mantenimiento_personal WHERE id_mantenimiento = ?";
        $stmt_mp = $conn->prepare($sql_mp);
        $stmt_mp->bind_param("i", $id_mant);
        $stmt_mp->execute();
        $stmt_mp->close();
    }
    $stmt->close();

    // 2. Eliminar mantenimientos
    $sql = "DELETE FROM mantenimientos WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 3. Eliminar exhibiciones
    $sql = "DELETE FROM exhibiciones WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 4. Eliminar tanques_batallas
    $sql = "DELETE FROM tanques_batallas WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 5. Eliminar especificaciones
    $sql = "DELETE FROM especificaciones WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 6. Finalmente, eliminar el tanque
    $sql = "DELETE FROM tanques WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    }

    // Eliminación en cascada manual de personal
    if ($tabla === "personal") {
        // Eliminar en mantenimiento_personal
        $sql = "DELETE FROM mantenimiento_personal WHERE id_personal = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Eliminar el personal principal
        $sql = "DELETE FROM personal WHERE id_personal = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    // Eliminación en cascada manual de paises
    if ($tabla === "paises") {
        // 1. Buscar tanques de este país
        $sql = "SELECT id_tanque FROM tanques WHERE id_pais = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $id_tanque = $row['id_tanque'];

            // 2. Eliminar dependencias de cada tanque
            $sql_dep = "DELETE FROM especificaciones WHERE id_tanque = ?";
            $stmt_dep = $conn->prepare($sql_dep);
            $stmt_dep->bind_param("i", $id_tanque);
            $stmt_dep->execute();
            $stmt_dep->close();

            $sql_dep = "DELETE FROM tanques_batallas WHERE id_tanque = ?";
            $stmt_dep = $conn->prepare($sql_dep);
            $stmt_dep->bind_param("i", $id_tanque);
            $stmt_dep->execute();
            $stmt_dep->close();

            $sql_dep = "DELETE FROM mantenimientos WHERE id_tanque = ?";
            $stmt_dep = $conn->prepare($sql_dep);
            $stmt_dep->bind_param("i", $id_tanque);
            $stmt_dep->execute();
            $stmt_dep->close();

            $sql_dep = "DELETE FROM exhibiciones WHERE id_tanque = ?";
            $stmt_dep = $conn->prepare($sql_dep);
            $stmt_dep->bind_param("i", $id_tanque);
            $stmt_dep->execute();
            $stmt_dep->close();

            // 3. Finalmente elimina el tanque
            $sql_dep = "DELETE FROM tanques WHERE id_tanque = ?";
            $stmt_dep = $conn->prepare($sql_dep);
            $stmt_dep->bind_param("i", $id_tanque);
            $stmt_dep->execute();
            $stmt_dep->close();
        }
        $stmt->close();

        // 4. Eliminar el país principal
        $sql = "DELETE FROM paises WHERE id_pais = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    // Eliminación en cascada manual de mantenimientos
    if ($tabla === "mantenimientos") {
        // Eliminar en mantenimiento_personal
        $sql = "DELETE FROM mantenimiento_personal WHERE id_mantenimiento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Eliminar el mantenimiento principal
        $sql = "DELETE FROM mantenimientos WHERE id_mantenimiento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    // Eliminación en cascada manual de exhibiciones
    if ($tabla === "exhibiciones") {
        // Eliminar exhibicion_evento
        $sql = "DELETE FROM exhibicion_evento WHERE id_exhibicion = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Eliminar la exhibición principal
        $sql = "DELETE FROM exhibiciones WHERE id_exhibicion = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    // Eliminación en cascada manual de eventos
    if ($tabla === "eventos") {
        // Eliminar en exhibicion_evento
        $sql = "DELETE FROM exhibicion_evento WHERE id_evento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Eliminar el evento principal
        $sql = "DELETE FROM eventos WHERE id_evento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    // Eliminación en cascada manual de batallas
    if ($tabla === "batallas") {
        // Eliminar en tanques_batallas
        $sql = "DELETE FROM tanques_batallas WHERE id_batalla = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Eliminar la batalla principal
        $sql = "DELETE FROM batallas WHERE id_batalla = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute()) {
        $mensaje = "<span style='color:green;font-weight:bold;'>Eliminación en cascada realizada con éxito.</span>";
    } else {
        $mensaje = "<span style='color:red;'>Error al eliminar el registro principal. Comprueba las restricciones de integridad referencial.</span>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dependencias encontradas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<?php include "menu.php"; ?>

<?php if ($mensaje): ?>
    <br><div class="mensaje-exito"><?= $mensaje ?></div><br>
    <form> <input type="submit" value="Regresar" formaction="<?= htmlspecialchars($tabla) ?>/read.php"></form>
    <?php exit; ?>
<?php endif; ?>

<h2>No puedes eliminar el registro seleccionado porque tiene relaciones en otras tablas</h2>
<p><strong>ID:</strong> <?= htmlspecialchars($id) ?> (<strong>Tabla:</strong> <?= htmlspecialchars($tabla) ?>)</p>
<p>Debes eliminar o modificar estos registros antes de poder eliminar el registro principal, o bien eliminar todas sus relaciones (ON CASCADE).</p>

<form method="post" action="" onsubmit="return confirm('¿Seguro que deseas borrar este registro y todas sus relaciones?');">
    <input type="hidden" name="on_cascade" value="1">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <input type="hidden" name="tabla" value="<?= htmlspecialchars($tabla) ?>">
    <input type="submit" value="Eliminar ON CASCADE">
</form>

<?php foreach ($dependencias as $nombre => $registros): ?>
    <?php if (count($registros) > 0): ?>
        <h3>Lista de <?= htmlspecialchars($nombre) ?></h3>
        <table>
            <tr>
                <?php foreach ($columnas[$nombre] as $columna => $campo): ?>
                    <th><?= htmlspecialchars($columna) ?></th>
                <?php endforeach; ?>
                <th class="acciones">Acciones</th>
            </tr>
            <?php foreach ($registros as $registro): ?>
                <tr>
                    <?php foreach ($columnas[$nombre] as $campo): ?>
                        <td><?= htmlspecialchars($registro[$campo]) ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="<?= $acciones[$nombre]['edit'] ?>?id=<?= $registro[$acciones[$nombre]['id']] ?>">Editar</a> |
                        <a href="<?= $acciones[$nombre]['delete'] ?>?id=<?= $registro[$acciones[$nombre]['id']] ?>"
                           onclick="return confirm('¿Seguro que deseas borrar este registro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endforeach; ?><br>
<form><input type="submit" value="Regresar" formaction="<?= htmlspecialchars($tabla) ?>/read.php"></form>
</body>
</html>