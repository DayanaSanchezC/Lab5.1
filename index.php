<?php
$servername = "lab51mysql.mysql.database.azure.com";
$username = "dayana@lab51mysql";
$password = "Estefania1.";
$dbname = "formulario_db";
$port = 3306;
$ssl = "/etc/ssl/certs/ca-certificates.crt";

// Para ver errores detallados
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname, $port, $ssl);
    echo "✅ Conexión exitosa.";
} catch (Exception $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
?>
