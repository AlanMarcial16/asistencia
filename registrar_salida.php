<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $id_empleado = $_POST["nombre"];
    $contrasena = $_POST["contrasena"];

    // Verificar la contraseña
    if ($contrasena !== 'password123') {
        echo "Contraseña incorrecta";
        exit; // Terminar la ejecución del script si la contraseña es incorrecta
    }

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

    // Obtener la hora de salida del formulario
    $hora_salida = $_POST["hora_salida"];

    // Actualizar el registro de asistencia con la hora de salida
    $sql = "UPDATE registros_asistencia SET hora_salida='$hora_salida' WHERE id_empleado='$id_empleado' AND fecha=CURRENT_DATE()";

    if ($conn->query($sql) === TRUE) {
        // Redirigir al usuario a form2.php después de registrar la salida
        header("Location: form2.php");
        exit;
    } else {
        echo "Error al registrar la salida: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
