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

    // Verificar si ya existe un registro para este empleado en la fecha actual
    $sql_check = "SELECT * FROM registros_asistencia WHERE id_empleado = '$id_empleado' AND fecha = '$fecha'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Ya hay un registro para este empleado en la fecha actual
        echo "Ya existe un registro de asistencia para este empleado en la fecha actual.";
    } else {
        // Insertar el nuevo registro de asistencia
        $sql_insert = "INSERT INTO registros_asistencia (id_empleado, fecha, hora_entrada) VALUES ('$id_empleado', '$fecha', '$hora_entrada')";
        
        if ($conn->query($sql_insert) === TRUE) {
            // Redireccionar a form.php
            header("Location: form.php");
            exit(); // Asegurarse de que el script no continúe ejecutándose después de la redirección
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }

    // Cerrar la conexión
    $conn->close();
}
?>
