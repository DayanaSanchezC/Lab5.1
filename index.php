<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$dbname = getenv("DB_NAME");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    if (!empty($nombre)) {
        $stmt = $conn->prepare("INSERT INTO personas (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        if ($stmt->execute()) {
            echo "✔ Nombre guardado.<br>";
        } else {
            echo "❌ Error al guardar el nombre: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "❗ El nombre no puede estar vacío.<br>";
    }
}

echo "<h2>Lista de nombres</h2>";
$result = $conn->query("SELECT * FROM personas");
while($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"] . " - Nombre: " . htmlspecialchars($row["nombre"]) . "<br>";
}
$conn->close();
?>
