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
    // Conexión a la base de datos
    $conn = new mysqli("10.0.0.4", "dayana", "Estefania1.", "formulario_db");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
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
