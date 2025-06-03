<?php
include_once "../config.php";
$sql = "SELECT * FROM mantenimiento_personal ORDER BY id_MP";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Mantenimiento Personal</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Relación Mantenimiento-Personal</h2>
<table>
    <tr>
        <th>ID Relación</th>
        <th>ID Mantenimiento</th>
        <th>ID Personal</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_MP'] ?></td>
        <td><?= $row['id_mantenimiento'] ?></td>
        <td><?= $row['id_personal'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_MP'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_MP'] ?>" onclick="return confirm('¿Seguro que deseas borrar esta relación?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table> <br>
<form><input type="submit" value="Agregar +" formaction="create.php"></form>
</body>
</html>