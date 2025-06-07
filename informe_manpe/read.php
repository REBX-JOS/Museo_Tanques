<?php
include_once "../config.php";
$datos = [];
$msg = "";

$query = "SELECT 
    m.id_mantenimiento,
    m.tipo_mantenimiento,
    m.notas,
    p.nombre_personal AS personal,
    t.nombre_tanque AS tanque
FROM mantenimientos m
JOIN mantenimiento_personal mp ON m.id_mantenimiento = mp.id_mantenimiento
JOIN personal p ON mp.id_personal = p.id_personal
JOIN tanques t ON m.id_tanque = t.id_tanque
WHERE m.tipo_mantenimiento = 'Correctivo'";

$res = $conn->query($query);
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $datos[] = $row;
    }
} else {
    $msg = "No hay mantenimientos correctivos.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Informe: Mantenimientos Correctivos</title>
    <link rel="stylesheet" href="/museotanques/estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Informe: Mantenimientos Correctivos</h2>
<?php if($msg) echo "<p>$msg</p>"; ?>
Descargar el informe en PDF:
<form action="download_informe.php" method="post" target="_blank" style="display:inline;">
    <input type="submit" value="Descargar informe en PDF" class="boton_pdf">  </form><br><br>
<?php if($datos): ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Notas</th>
            <th>Personal</th>
            <th>Tanque</th>
        </tr>
        <?php foreach($datos as $fila): ?>
            <tr>
                <td><?= htmlspecialchars($fila['id_mantenimiento']) ?></td>
                <td><?= htmlspecialchars($fila['tipo_mantenimiento']) ?></td>
                <td><?= htmlspecialchars($fila['notas']) ?></td>
                <td><?= htmlspecialchars($fila['personal']) ?></td>
                <td><?= htmlspecialchars($fila['tanque']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table><br>
    <form> <input type="submit" value="Regresar" formaction="../index.php"></form>
<?php endif; ?>
</body>
</html>