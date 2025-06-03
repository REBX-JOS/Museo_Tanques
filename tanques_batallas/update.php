<?php
include_once "../config.php";
$msg = "";
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "SELECT * FROM tanques_batallas WHERE id_TB=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $relacion = $stmt->get_result()->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_tanque = $_POST["id_tanque"];
        $id_batalla = $_POST["id_batalla"];
        $sql = "UPDATE tanques_batallas SET id_tanque=?, id_batalla=? WHERE id_TB=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $id_tanque, $id_batalla, $id);
        if ($stmt->execute()) {
            $msg = "Relación actualizada correctamente.";
        } else {
            $msg = "Error: " . $conn->error;
        }
    }
} else {
    header("Location: read.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Tanque-Batalla</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Editar Relación Tanque-Batalla</h2>
<form method="post">
    ID Tanque: <input type="number" name="id_tanque" value="<?= $relacion['id_tanque'] ?>" required><br>
    ID Batalla: <input type="number" name="id_batalla" value="<?= $relacion['id_batalla'] ?>" required><br>
    <input type="submit" value="Actualizar">
    <input type="submit" value="Regresar" formaction="read.php" formnovalidate>
</form>
<p><?= $msg ?></p>
</body>
</html>