<?php
// Archivo: verificar_salida.php

// Conexión a la base de datos (reemplaza con tus datos de conexión)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prueba";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener registros donde no se ha registrado la salida y calcular la hora de salida automática
$sql = "SELECT id, id_empleado, fecha, hora_entrada, info FROM registros_asistencia WHERE hora_salida IS NULL";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_registro = $row['id'];
        $id_empleado = $row['id_empleado'];
        $fecha = $row['fecha'];
        $hora_entrada = $row['hora_entrada'];
        $info_actual = $row['info'];

        // Calcular la hora de salida esperada (hora de entrada + 8 horas + 15 minutos)
        $entrada_timestamp = strtotime($hora_entrada);
        $duracion_horas = 8;
        $duracion_minutos = 15;
        $duracion_total_segundos = ($duracion_horas * 3600) + ($duracion_minutos * 60);
        $salida_timestamp = $entrada_timestamp + $duracion_total_segundos;
        $salida_esperada = date("H:i:s", $salida_timestamp);

        // Obtener la hora actual
        $hora_actual = date("H:i:s");

        // Verificar si la hora actual es mayor o igual a la hora de salida esperada
        if ($hora_actual >= $salida_esperada) {
            // Preparar el nuevo valor de la columna info
            $nuevo_info = "salida tardía AUTOMÁTICA";
            if ($info_actual) {
                $info_actual .= ", " . $nuevo_info;
            } else {
                $info_actual = $nuevo_info;
            }

            // Realizar el registro automático de salida y actualizar la columna info
            $sql_update = "UPDATE registros_asistencia SET hora_salida = '$hora_actual', info = '$info_actual' WHERE id = $id_registro";
            if ($conn->query($sql_update) === TRUE) {
                echo "Se ha registrado automáticamente la salida para el empleado con ID $id_empleado en la fecha $fecha a las $hora_actual.";
                
                // Aquí podrías enviar una notificación al empleado si lo deseas
                
            } else {
                echo "Error al registrar la salida automática: " . $conn->error;
            }
        } else {
            echo "No se requiere registro automático de salida en este momento para el empleado con ID $id_empleado.";
        }
    }
} else {
    echo "No hay registros pendientes de salida automática en la base de datos.";
}

$conn->close();
?>
