<?php
include_once "../config.php";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_pais = $_POST["nombre_pais"];
    $capital = $_POST["capital"];
    $region = $_POST["region"];

    // Verificar si ya existe el nombre de país para evitar duplicados
    $check = $conn->prepare("SELECT 1 FROM paises WHERE nombre_pais = ?");
    $check->bind_param("s", $nombre_pais);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $msg = "Ya existe un país con ese nombre.";
    } else {
        $sql = "INSERT INTO paises (nombre_pais, capital, region) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre_pais, $capital, $region);
        if ($stmt->execute()) {
            $msg = "País creado correctamente.";
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear País</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Crear País</h2>
<form method="post">
    Nombre País: <input type="text" name="nombre_pais" maxlength="100" required><br>
    Capital: <input type="text" name="capital" maxlength="100" required><br>
    Región: <input type="text" name="region" maxlength="100" required><br>
    <input type="submit" value="Crear">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>