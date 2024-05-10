<?php
// Incluir la biblioteca PHP QR Code
require 'phpqrcode/qrlib.php';

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "prueba";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los datos de los empleados
$sql = "SELECT id, nombre FROM empleados";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result && $result->num_rows > 0) {
    // Iterar sobre cada empleado
    while($row = $result->fetch_assoc()) {
        // Generar el contenido del código QR (por ejemplo, el ID del empleado)
        $qrContent = $row["id"];

        // Nombre del archivo para guardar el código QR
        $qrFileName = "qr_codes/qr_" . $row["nombre"] . ".png";

        // Generar el código QR y guardarlo en un archivo
        QRcode::png($qrContent, $qrFileName, QR_ECLEVEL_L, 10);

        echo "Código QR generado para el empleado: " . $row["nombre"] . "<br>";
        echo '<img src="' . $qrFileName . '" alt="Código QR de ' . $row["nombre"] . '"><br>';
    }
} else {
    echo "No se encontraron empleados.";
}

// Cerrar la conexión
$conn->close();
?>
