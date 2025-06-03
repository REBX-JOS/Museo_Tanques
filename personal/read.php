<?php
include_once "../config.php";
$sql = "SELECT * FROM personal ORDER BY id_personal";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Personal</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Personal</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Puesto</th>
        <th>Teléfono</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_personal'] ?></td>
        <td><?= $row['nombre_personal'] ?></td>
        <td><?= $row['puesto'] ?></td>
        <td><?= $row['num_tel'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_personal'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_personal'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este registro?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table><br>
<form> <input type="submit" value="Agregar +" formaction="create.php"> </form>
</body>
</html>