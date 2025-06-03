<?php
include_once "../config.php";
$sql = "SELECT * FROM mantenimientos ORDER BY id_mantenimiento";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Mantenimientos</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Mantenimientos</h2>
<table>
    <tr>
        <th>ID</th>
        <th>ID Tanque</th>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Notas</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_mantenimiento'] ?></td>
        <td><?= $row['id_tanque'] ?></td>
        <td><?= $row['fecha_mantenimiento'] ?></td>
        <td><?= $row['tipo_mantenimiento'] ?></td>
        <td><?= $row['notas'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_mantenimiento'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_mantenimiento'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este mantenimiento?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table><br>
<form><input type="submit" value="Agregar +" formaction="create.php">  </form>
</body>
</html>