<?php
include_once "../config.php";
$sql = "SELECT * FROM vistatanquesybatallas";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vista Tanques y Batallas</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Vista: Tanques y Batallas</h2>
<table>
    <tr>
        <th>Nombre Tanque</th>
        <th>Modelo</th>
        <th>Nombre Batalla</th>
        <th>Lugar Batalla</th>
        <th>Fecha</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['nombre_tanque'] ?></td>
        <td><?= $row['modelo'] ?></td>
        <td><?= $row['nombre_batalla'] ?></td>
        <td><?= $row['lugar_batalla'] ?></td>
        <td><?= $row['fecha'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>