<?php
include_once "../config.php";
$sql = "SELECT * FROM paises ORDER BY id_pais";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Países</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Países</h2>
<table>
    <tr>
        <th>ID País</th>
        <th>Nombre</th>
        <th>Capital</th>
        <th>Región</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_pais'] ?></td>
        <td><?= $row['nombre_pais'] ?></td>
        <td><?= $row['capital'] ?></td>
        <td><?= $row['region'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_pais'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_pais'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este país?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table><br>
<form><input type="submit" value="Agregar +" formaction="create.php">  </form>
</body>
</html>