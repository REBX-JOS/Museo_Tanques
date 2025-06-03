<?php
include_once "../config.php";
$sql = "SELECT * FROM batallas ORDER BY id_batalla";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Batallas</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Batallas</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Nombre</th>
        <th>Lugar</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_batalla'] ?></td>
        <td><?= $row['fecha'] ?></td>
        <td><?= $row['nombre_batalla'] ?></td>
        <td><?= $row['lugar_batalla'] ?></td>
        <td><?= $row['descripcion_batalla'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_batalla'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_batalla'] ?>" onclick="return confirm('¿Seguro que deseas borrar esta batalla?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table> <br>
<form><input type="submit" value="Agregar +" formaction="create.php"></form>
</body>
</html>