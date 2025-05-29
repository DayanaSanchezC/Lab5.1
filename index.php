<!DOCTYPE html>
<html>
<head>
    <title>Formulario</title>
</head>
<body>
    <h2>Agregar nombre</h2>
    <form method="post">
        Nombre: <input type="text" name="nombre" required>
        <input type="submit" value="Guardar">
    </form>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $host = "lab51mysql.mysql.database.azure.com";
    $username = "dayana";  
    $password = "Estefania1.";  
    $database = "formulario_db";
    $port = 3306;
    $ssl_cert = "/etc/ssl/certs/ca-certificates.crt"; 

    // Inicializar conexión con SSL
    $conn = mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, $ssl_cert, NULL, NULL);

    // Realizar conexión
    if (!mysqli_real_connect($conn, $host, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL)) {
        die("❌ Error de conexión: " . mysqli_connect_error());
    }

    // Guardar nombre si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST['nombre']);
        if (!empty($nombre)) {
            $stmt = $conn->prepare("INSERT INTO personas (nombre) VALUES (?)");
            $stmt->bind_param("s", $nombre);
            if ($stmt->execute()) {
                echo "✔ Nombre guardado.<br><br>";
            } else {
                echo "❌ Error al guardar el nombre: " . $stmt->error . "<br><br>";
            }
            $stmt->close();
        } else {
            echo "❗ El nombre no puede estar vacío.<br><br>";
        }
    }

    // Mostrar nombres guardados
    echo "<h2>Lista de nombres</h2>";
    $result = $conn->query("SELECT * FROM personas");
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Nombre: " . htmlspecialchars($row["nombre"]) . "<br>";
    }

    $conn->close();
    ?>
</body>
</html>
