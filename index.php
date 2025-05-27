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
    // CONFIGURA TUS DATOS DE CONEXIÓN AQUÍ
    $servername = "lab51mysql.mysql.database.azure.com"; 
    $username = "dayana@NOMBREDELHOST"; // ← incluye el @host
    $password = "Estefania1.";
    $dbname = "formulario_db";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("❌ Conexión fallida: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST['nombre']);

        if (!empty($nombre)) {
            $stmt = $conn->prepare("INSERT INTO personas (nombre) VALUES (?)");
            $stmt->bind_param("s", $nombre);
            if ($stmt->execute()) {
                echo "✔ Nombre guardado.<br><br>";
            } else {
                echo "❌ Error al guardar el nombre.<br><br>";
            }
            $stmt->close();
        } else {
            echo "❗ El nombre no puede estar vacío.<br><br>";
        }
    }

    echo "<h2>Lista de nombres</h2>";
    $result = $conn->query("SELECT * FROM personas");

    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Nombre: " . htmlspecialchars($row["nombre"]) . "<br>";
    }

    $conn->close();
    ?>
</body>
</html>
