<?php
include_once "config.php";
$id = $_GET['id'] ?? null;
$tabla = $_GET['tabla'] ?? null;

if (!$id || !$tabla) {
    echo "Falta información.";
    exit;
}

$dependencias = [];

// Consulta dependencias según la tabla (ejemplo para tanques)
if ($tabla === "tanques") {
    // Exhibiciones relacionadas
    $sql = "SELECT * FROM exhibiciones WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['exhibiciones'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Mantenimientos relacionados
    $sql = "SELECT * FROM mantenimientos WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['mantenimientos'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Tanques_batallas relacionadas
    $sql = "SELECT * FROM tanques_batallas WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['tanques_batallas'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Especificaciones relacionadas
    $sql = "SELECT * FROM especificaciones WHERE id_tanque = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dependencias['especificaciones'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    // ... agrega más si hay otras tablas relacionadas
}

// Agrega lógica similar para otras tablas si lo requieres

?>
<!DOCTYPE html>
<html>
<head>
    <title>Dependencias encontradas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>No puedes eliminar el registro seleccionado porque tiene relaciones en otras tablas</h2>
    <p>ID: <?= htmlspecialchars($id) ?> (Tabla: <?= htmlspecialchars($tabla) ?>)</p>
    <?php foreach ($dependencias as $nombre => $registros): ?>
        <?php if (count($registros) > 0): ?>
            <h3><?= ucfirst($nombre) ?> relacionadas:</h3>
            <ul>
            <?php foreach ($registros as $registro): ?>
                <li>
                    <?php foreach ($registro as $campo => $valor): ?>
                        <?= htmlspecialchars($campo) ?>: <?= htmlspecialchars($valor) ?> |
                    <?php endforeach; ?>
                    <!-- Aquí puedes poner un link para editar/eliminar ese registro -->
                </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endforeach; ?>
    <p>Debes eliminar o modificar estos registros antes de poder eliminar el registro principal.</p>
    <a href="<?= htmlspecialchars($tabla) ?>/read.php">Volver</a>
</body>
</html>