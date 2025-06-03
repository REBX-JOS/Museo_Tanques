<?php
include_once "../config.php";
$sql = "SELECT * FROM especificaciones ORDER BY id_tanque";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Especificaciones</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Especificaciones</h2>
<table>
    <tr>
        <th>ID Tanque</th>
        <th>Peso (toneladas)</th>
        <th>Longitud (metros)</th>
        <th>Blindaje (mm)</th>
        <th>Velocidad (km/h)</th>
        <th>Armamento Principal</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_tanque'] ?></td>
        <td><?= $row['peso_toneladas'] ?></td>
        <td><?= $row['longitud_metros'] ?></td>
        <td><?= $row['blindaje_mm'] ?></td>
        <td><?= $row['velocidad_kmh'] ?></td>
        <td><?= $row['armamento_principal'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_tanque'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_tanque'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta especificación?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table> <br>
<form><input type="submit" value="Agregar +" formaction="create.php"></form>
</body>
</html>