<?php
include_once "../config.php";
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    // --- CIFRADO AES EN PHP ---
    $key = 'clavesecreta'; // Cambiar por una clave segura y única
    $ivlen = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivlen);
    $cifrado_raw = openssl_encrypt($contrasena, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    $cifrado_final = base64_encode($iv . $cifrado_raw); // Guardamos IV + cifrado

    // Guardar en DB
    $sql = "INSERT INTO Usuarios (usuario, contrasena) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $cifrado_final);

    if ($stmt->execute()) {
        $msg = "Usuario registrado correctamente.";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<?php include "../menu.php"; ?>
<h2>Registrar Usuario</h2>
<form method="post">
    Usuario: <input type="text" name="usuario" required maxlength="20"><br>
    Contraseña: <input type="password" name="contrasena" required maxlength="30"><br><br>
    <input type="submit" value="Registrar">
</form>
<p><?= $msg ?></p>
</body>
</html>