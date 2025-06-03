<?php
include_once "../config.php";
$sql = "SELECT t.*, p.nombre_pais FROM tanques t LEFT JOIN paises p ON t.id_pais = p.id_pais ORDER BY t.id_tanque";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Tanques</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Lista de Tanques</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Modelo</th>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Año Fabricación</th>
        <th>País</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_tanque'] ?></td>
        <td><?= $row['modelo'] ?></td>
        <td><?= $row['nombre_tanque'] ?></td>
        <td><?= $row['tipo_tanque'] ?></td>
        <td><?= $row['anio_fabricacion'] ?></td>
        <td><?= $row['nombre_pais'] ?></td>
        <td>
            <a href="update.php?id=<?= $row['id_tanque'] ?>">Editar</a> |
            <a href="delete.php?id=<?= $row['id_tanque'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este tanque?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table><br>
<form> <input type="submit" value="Agregar +" formaction="create.php"> </form>
</body>
</html>