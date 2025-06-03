<?php
include_once "../config.php";
$sql = "SELECT * FROM exhibiciones ORDER BY id_exhibicion";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Exhibiciones</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Exhibiciones</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Lugar</th>
        <th>Descripción</th>
        <th>ID Tanque</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_exhibicion'] ?></td>
        <td><?= $row['fecha_exhibicion'] ?></td>
        <td><?= $row['lugar_exhibicion'] ?></td>
        <td><?= $row['descripcion_exhibicion'] ?></td>
        <td><?= $row['id_tanque'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_exhibicion'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_exhibicion'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta exhibición?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table><br>
<form><input type="submit" value="Agregar +" formaction="create.php">  </form>
</body>
</html>