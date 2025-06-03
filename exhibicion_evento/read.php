<?php
include_once "../config.php";
$sql = "SELECT * FROM exhibicion_evento ORDER BY id_EVEX";
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
        <th>ID Evento</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_EVEX'] ?></td>
        <td><?= $row['id_exhibicion'] ?></td>
        <td><?= $row['id_evento'] ?></td>
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