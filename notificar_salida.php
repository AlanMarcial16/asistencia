<?php
// Archivo: notificar_salida.php

// Incluir la biblioteca PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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

// Consulta para obtener registros donde no se ha registrado la salida
$sql = "SELECT id, id_empleado, fecha, hora_entrada FROM registros_asistencia WHERE hora_salida IS NULL";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    
    // Configuración del servidor SMTP para MailHog
    $mail->isSMTP();
    $mail->Host = 'localhost';  // Debes ajustar el host según tu configuración de MailHog
    $mail->Port = 1025;         // Puerto predeterminado de MailHog para SMTP
    $mail->SMTPAuth = false;    // MailHog no requiere autenticación
    $mail->SMTPSecure = false;  // No se necesita conexión segura para MailHog

    while ($row = $result->fetch_assoc()) {
        $id_registro = $row['id'];
        $id_empleado = $row['id_empleado'];
        $fecha = $row['fecha'];
        $hora_entrada = $row['hora_entrada'];

        // Calcular hora límite para la salida (hora de entrada + 7 horas y 50 minutos)
        $entrada_timestamp = strtotime($hora_entrada);
        $duracion_horas = 7;
        $duracion_minutos = 50;
        $duracion_total_segundos = ($duracion_horas * 3600) + ($duracion_minutos * 60);
        $limite_timestamp = $entrada_timestamp + $duracion_total_segundos;
        $limite_salida = date("H:i:s", $limite_timestamp);

        // Obtener la hora actual
        $hora_actual = date("H:i:s");

        // Verificar si la hora actual supera el límite calculado
        if ($hora_actual >= $limite_salida) {
            // Obtener información del empleado para la notificación
            $sql_empleado = "SELECT nombre, correo FROM empleados WHERE id = $id_empleado";
            $result_empleado = $conn->query($sql_empleado);

            if ($result_empleado->num_rows > 0) {
                $row_empleado = $result_empleado->fetch_assoc();
                $nombre_empleado = $row_empleado['nombre'];
                $correo_empleado = $row_empleado['correo'];

                try {
                    // Configuración del remitente y destinatario
                    $mail->setFrom('tu_correo@example.com', 'Tu Nombre');
                    $mail->addAddress($correo_empleado, $nombre_empleado);

                    // Contenido del correo electrónico
                    $mail->isHTML(true);
                    $mail->Subject = 'Recordatorio: Registra tu salida';
                    $mail->Body = "Hola $nombre_empleado,<br><br>Este es un recordatorio para que registres tu salida antes de las $limite_salida.<br><br>Saludos,<br>Tu equipo de asistencia.";

                    // Enviar el correo electrónico
                    $mail->send();
                    echo "Notificación enviada a $nombre_empleado ($correo_empleado): Debes registrar tu salida antes de las $limite_salida.";
                    echo "<br>";
                } catch (Exception $e) {
                    echo "Error al enviar la notificación por correo electrónico a $correo_empleado: {$mail->ErrorInfo}";
                    echo "<br>";
                }
            } else {
                echo "No se encontró información del empleado con ID $id_empleado.";
                echo "<br>";
            }
        } else {
            echo "No se requiere notificación para el empleado con ID $id_empleado en este momento.";
            echo "<br>";
        }
    }
} else {
    echo "No hay registros pendientes de salida en la base de datos.";
    echo "<br>";
}

$conn->close();
?>
