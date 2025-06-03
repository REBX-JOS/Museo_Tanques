<?php
include_once "config.php";
$id = $_GET['id'] ?? null;
$tabla = $_GET['tabla'] ?? null;

if (!$id || !$tabla) {
    echo "Falta información.";
    exit;
}

$dependencias = [];
// Definir columnas y archivos de acción para cada relación
$columnas = [];
$acciones = [];

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

/*if($tabla === 'exhibicion_evento') {
    // Exhibiciones relacionadas
    $sql = "SELECT * FROM exhibiciones WHERE id_exhibicion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Exhibiciones'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Exhibiciones'] = [
        'ID Exhibición' => 'id_exhibicion',
        'Fecha' => 'fecha_exhibicion',
        'Lugar' => 'lugar_exhibicion',
        'Descripción' => 'descripcion_exhibicion',
        'Tanque' => 'id_tanque'
    ];
    $acciones['Exhibiciones'] = [
        'edit' => 'exhibiciones/update.php',
        'delete' => 'exhibiciones/delete.php',
        'id' => 'id_exhibicion'
    ];

    // Eventos relacionados
    $sql = "SELECT * FROM eventos WHERE id_evento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['Eventos'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $columnas['Eventos'] = [
        'ID Evento' => 'id_evento',
        'Nombre' => 'nombre_evento',
        'Fecha Inicio' => 'fecha_in',
        'Fecha Fin' => 'fecha_fin',
        'Fecha' => 'fecha_evento',
        'Descripción' => 'descripcion_evento'
    ];
    $acciones['Eventos'] = [
        'edit' => 'eventos/update.php',
        'delete' => 'eventos/delete.php',
        'id' => 'id_evento'
    ];
}*/

if($tabla === 'exhibiciones') {
    // Exhibicion_evento relacionadas
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

    // Tanques relacionados
    $sql = "SELECT * FROM tanques WHERE id_tanque = ?";
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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dependencias encontradas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<?php include "menu.php"; ?>
<h2>No puedes eliminar el registro seleccionado porque tiene relaciones en otras tablas</h2>
<p><strong>ID:</strong> <?= htmlspecialchars($id) ?> (<strong>Tabla:</strong> <?= htmlspecialchars($tabla) ?>)</p>
<p>Debes eliminar o modificar estos registros antes de poder eliminar el registro principal.</p>
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