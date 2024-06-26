<?php
// Verificar si se han recibido los datos del escaneo del código QR
if (isset($_POST["id"]) && isset($_POST["fecha"]) && isset($_POST["hora"])) {
    // Recibir los datos del escaneo del código QR
    $id_empleado = $_POST["id"];
    $fecha = $_POST["fecha"];
    $hora_salida = $_POST["hora"];

    // Conectar a la base de datos y realizar la actualización
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "prueba";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si la salida es tardía
    $salida_timestamp = strtotime($hora_salida);
    $minutos_transcurridos = date('i', $salida_timestamp);
    $nuevo_info = NULL;

    if ($minutos_transcurridos > 15) {
        $nuevo_info = "salida tardía";
    }

    if ($nuevo_info) {
        // Obtener el valor actual de la columna info
        $sql_info = "SELECT info FROM registros_asistencia WHERE id_empleado='$id_empleado' AND fecha='$fecha'";
        $result_info = $conn->query($sql_info);
        $info_actual = "";

        if ($result_info->num_rows > 0) {
            $row_info = $result_info->fetch_assoc();
            $info_actual = $row_info["info"];
        }

        // Actualizar el valor de la columna info concatenando el nuevo comentario si existe
        if ($info_actual) {
            $info_actual .= ", " . $nuevo_info;
        } else {
            $info_actual = $nuevo_info;
        }

        $sql_update_info = "UPDATE registros_asistencia SET hora_salida='$hora_salida', info='$info_actual' WHERE id_empleado='$id_empleado' AND fecha='$fecha'";
    } else {
        // Actualizar solo la hora de salida
        $sql_update_info = "UPDATE registros_asistencia SET hora_salida='$hora_salida' WHERE id_empleado='$id_empleado' AND fecha='$fecha'";
    }

    if ($conn->query($sql_update_info) === TRUE) {
        echo "success";
    } else {
        echo "Error al registrar la salida: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No se han recibido los datos del escaneo del código QR.";
}
?>
