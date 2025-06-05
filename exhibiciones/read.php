<?php
include_once "../config.php";
$sql = "SELECT e.*, t.nombre_tanque FROM exhibiciones e JOIN tanques t ON e.id_tanque = t.id_tanque ORDER BY e.id_exhibicion";
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
        <th>Nombre</th>
        <th>Fecha</th>
        <th>Lugar</th>
        <th>Descripción</th>
        <th>ID Tanque</th>
        <th>Nombre Tanque</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_exhibicion'] ?></td>
        <td><?= $row['nombre_ex'] ?></td>
        <td><?= $row['fecha_exhibicion'] ?></td>
        <td><?= $row['lugar_exhibicion'] ?></td>
        <td><?= $row['descripcion_exhibicion'] ?></td>
        <td><?= $row['id_tanque'] ?></td>
        <td><?= htmlspecialchars($row['nombre_tanque']) ?></td>
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