<?php
include_once "../config.php";
$sql = "SELECT * FROM eventos ORDER BY id_evento";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Eventos</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Eventos</h2>
<table>
    <tr>
        <th>ID Evento</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_evento'] ?></td>
        <td><?= $row['fecha_in'] ?></td>
        <td><?= $row['fecha_fin'] ?></td>
        <td><?= $row['nombre_evento'] ?></td>
        <td><?= $row['descripcion_evento'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_evento'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_evento'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este evento?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table> <br>
<form><input type="submit" value="Agregar +" formaction="create.php"></form>
</body>
</html>