<?php
// Verificar si se han recibido los datos del escaneo del código QR
if (isset($_POST["id"]) && isset($_POST["fecha"]) && isset($_POST["hora"])) {
    // Recibir los datos del escaneo del código QR
    $id_empleado = $_POST["id"];
    $fecha = $_POST["fecha"];
    $hora_entrada = $_POST["hora"];

    // Conectar a la base de datos y realizar la actualización
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "prueba";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Actualizar el registro de asistencia con la hora de salida
    $sql = "UPDATE registros_asistencia SET hora_salida='$hora_entrada' WHERE id_empleado='$id_empleado' AND fecha='$fecha'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error al registrar la salida: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No se han recibido los datos del escaneo del código QR.";
}
?>
