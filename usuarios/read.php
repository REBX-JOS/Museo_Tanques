<?php
include_once "../config.php";
$sql = "SELECT * FROM usuarios ORDER BY id_usuario";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Usuarios</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Usuarios</h2>
<table>
    <tr>
        <th>ID Usuario</th>
        <th>Nombre</th>
        <!--<th>Acciones</th>-->
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_usuario'] ?></td>
        <td><?= $row['usuario'] ?></td>
       <!--<td>
            <a href="update.php?id=<?= $row['id_usuario'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_usuario'] ?>" onclick="return confirm('¿Seguro que deseas borrar este usuario?')">Eliminar</a>
        </td>-->
    </tr>
    <?php endwhile; ?>
</table> <br>
<form><input type="submit" value="Agregar +" formaction="create.php"></form>
</body>
</html>