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

    // Verificar si existe un registro para el id_empleado y la fecha de hoy
    $sql_check = "SELECT * FROM registros_asistencia WHERE id_empleado='$id_empleado' AND fecha='$fecha'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Si existe un registro, seguir la lógica original para actualizar la hora de salida
        $row = $result_check->fetch_assoc();

        // Verificar si la salida es tardía
        $salida_timestamp = strtotime($hora_salida);
        $minutos_transcurridos = date('i', $salida_timestamp);
        $nuevo_info = NULL;

        if ($minutos_transcurridos > 15) {
            $nuevo_info = "salida tardía";
        }

        if ($nuevo_info) {
            // Obtener el valor actual de la columna info
            $info_actual = $row["info"];
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
    } else {
        // Si no existe un registro, crear uno nuevo
        // Calcular la hora de entrada restando 8 horas a la hora de salida
        $hora_entrada_timestamp = strtotime($hora_salida) - 8 * 3600;
        $hora_entrada = date('H:i:s', $hora_entrada_timestamp);

        $info_nuevo = "Entrada registrada de forma automática";

        // Insertar el nuevo registro en la tabla
        $sql_insert = "INSERT INTO registros_asistencia (id_empleado, fecha, hora_entrada, hora_salida, info) 
                       VALUES ('$id_empleado', '$fecha', '$hora_entrada', '$hora_salida', '$info_nuevo')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "success";
        } else {
            echo "Error al insertar el nuevo registro: " . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "No se han recibido los datos del escaneo del código QR.";
}
?>
