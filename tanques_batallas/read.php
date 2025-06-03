<?php
include_once "../config.php";
$sql = "SELECT * FROM tanques_batallas ORDER BY id_TB";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Tanques-Batallas</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Relación Tanque-Batalla</h2>
<table>
    <tr>
        <th>ID Relación</th>
        <th>ID Tanque</th>
        <th>ID Batalla</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_TB'] ?></td>
        <td><?= $row['id_tanque'] ?></td>
        <td><?= $row['id_batalla'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_TB'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_TB'] ?>" onclick="return confirm('¿Seguro que deseas borrar esta relación?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table> <br>
<form><input type="submit" value="Agregar +" formaction="create.php"></form>
</body>
</html>