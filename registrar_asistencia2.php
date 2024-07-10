<?php
// Verificar si se han recibido los datos del escaneo del código QR
if (isset($_GET["id"]) && isset($_GET["fecha"]) && isset($_GET["hora"])) {
    // Recibir los datos del escaneo del código QR
    $id_empleado = $_GET["id"];
    $fecha = $_GET["fecha"];
    $hora_entrada = $_GET["hora"];

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
        // Verificar si la entrada es tardía
        $entrada_timestamp = strtotime($hora_entrada);
        $minutos_transcurridos = date('i', $entrada_timestamp);
        $info = NULL;

        if ($minutos_transcurridos > 15) {
            $info = "entrada tardía";
        }

        // Insertar el nuevo registro de asistencia
        $sql_insert = "INSERT INTO registros_asistencia (id_empleado, fecha, hora_entrada, info) VALUES ('$id_empleado', '$fecha', '$hora_entrada', '$info')";
        
        if ($conn->query($sql_insert) === TRUE) {
            // Redireccionar a form.php
            header("Location: index.php");
            exit(); // Asegurarse de que el script no continúe ejecutándose después de la redirección
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no se reciben los datos del escaneo del código QR, redireccionar a algún lugar adecuado
    header("Location: alguna_pagina_de_error.php");
    exit();
}
?>
