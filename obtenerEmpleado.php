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

// Consultar el nombre del empleado
$sql = "SELECT nombre FROM empleados WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $empleadoId);
$stmt->execute();
$stmt->bind_result($nombre);
$stmt->fetch();
$stmt->close();

if ($nombre) {
    // Contar los retardos del empleado
    $sql = "SELECT COUNT(*) as retardos FROM registros_asistencia WHERE id_empleado = ? AND info LIKE '%entrada tardía%'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $empleadoId);
    $stmt->execute();
    $stmt->bind_result($retardos);
    $stmt->fetch();
    $stmt->close();

    echo json_encode(['nombre' => $nombre, 'retardos' => $retardos]);
} else {
    echo json_encode(['error' => 'Empleado no encontrado']);
}

$conn->close();
?>
