<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prueba";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]));
}

$empleadoId = $_POST['id'];

$sql = "SELECT nombre FROM empleados WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $empleadoId);
$stmt->execute();
$stmt->bind_result($nombre);
$stmt->fetch();

if ($nombre) {
    echo json_encode(['nombre' => $nombre]);
} else {
    echo json_encode(['error' => 'Empleado no encontrado']);
}

$stmt->close();
$conn->close();
?>
