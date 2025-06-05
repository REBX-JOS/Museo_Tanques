<?php
include_once "../config.php";
$datos = [];
$msg = "";

$query = "SELECT 
    e.id_evento,
    e.nombre_evento,
    e.descripcion_evento,
    ex.id_exhibicion,
    ex.lugar_exhibicion,
    ex.descripcion_exhibicion
FROM eventos e
JOIN exhibicion_evento ee ON e.id_evento = ee.id_evento
JOIN exhibiciones ex ON ee.id_exhibicion = ex.id_exhibicion";

$res = $conn->query($query);
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $datos[] = $row;
    }
} else {
    $msg = "No hay eventos con exhibiciones.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Informe: Eventos con Exhibiciones</title>
    <link rel="stylesheet" href="/museotanques/estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Informe: Eventos con Exhibiciones</h2>
<?php if($msg) echo "<p>$msg</p>"; ?>
<?php if($datos): ?>
    <table border="1">
        <tr>
            <th>ID Evento</th>
            <th>Nombre Evento</th>
            <th>Descripción Evento</th>
            <th>ID Exhibición</th>
            <th>Lugar Exhibición</th>
            <th>Descripción Exhibición</th>
        </tr>
        <?php foreach($datos as $fila): ?>
            <tr>
                <td><?= htmlspecialchars($fila['id_evento']) ?></td>
                <td><?= htmlspecialchars($fila['nombre_evento']) ?></td>
                <td><?= htmlspecialchars($fila['descripcion_evento']) ?></td>
                <td><?= htmlspecialchars($fila['id_exhibicion']) ?></td>
                <td><?= htmlspecialchars($fila['lugar_exhibicion']) ?></td>
                <td><?= htmlspecialchars($fila['descripcion_exhibicion']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</body>
</html>