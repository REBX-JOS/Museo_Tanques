<?php
include_once "../config.php";
$sql = "SELECT ee.id_EVEX, 
               e.id_exhibicion, 
               e.nombre_ex, 
               ev.id_evento, 
               ev.nombre_evento
        FROM exhibicion_evento ee
        JOIN exhibiciones e ON ee.id_exhibicion = e.id_exhibicion
        JOIN eventos ev ON ee.id_evento = ev.id_evento
        ORDER BY ee.id_EVEX";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Exhibición-Evento</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Relación Exhibición-Evento</h2>
<table>
    <tr>
        <th>ID Relación</th>
        <th>ID Exhibición</th>
        <th>Nombre Exhibición</th>
        <th>ID Evento</th>
        <th>Nombre Evento</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_EVEX'] ?></td>
        <td><?= $row['id_exhibicion'] ?></td>
        <td><?= htmlspecialchars($row['nombre_ex']) ?></td>
        <td><?= $row['id_evento'] ?></td>
        <td><?= htmlspecialchars($row['nombre_evento']) ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_EVEX'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_EVEX'] ?>" onclick="return confirm('¿Seguro que deseas borrar esta relación?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table> <br>
<form><input type="submit" value="Agregar +" formaction="create.php"></form>
</body>
</html>