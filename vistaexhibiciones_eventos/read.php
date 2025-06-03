<?php
include_once "../config.php";
$sql = "SELECT * FROM vistaexhibicionesyeventos";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vista Exhibiciones y Eventos</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Vista: Exhibiciones y Eventos</h2>
<table>
    <tr>
        <th>ID Exhibición</th>
        <th>Fecha Exhibición</th>
        <th>Lugar Exhibición</th>
        <th>Nombre Evento</th>
        <th>Descripción Evento</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_exhibicion'] ?></td>
        <td><?= $row['fecha_exhibicion'] ?></td>
        <td><?= $row['lugar_exhibicion'] ?></td>
        <td><?= $row['nombre_evento'] ?></td>
        <td><?= $row['descripcion_evento'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>