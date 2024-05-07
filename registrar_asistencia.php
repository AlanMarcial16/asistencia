<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $id_empleado = $_POST["nombre"];
    $fecha = $_POST["fecha"];
    $hora_entrada = $_POST["hora_entrada"];

    // Conectar a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "prueba";

    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Insertar el nuevo registro de asistencia
    $sql = "INSERT INTO registros_asistencia (id_empleado, fecha, hora_entrada) VALUES ('$id_empleado', '$fecha', '$hora_entrada')";

    if ($conn->query($sql) === TRUE) {
        // Redireccionar a form.php
        header("Location: form.php");
        exit(); // Asegurarse de que el script no continúe ejecutándose después de la redirección
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
