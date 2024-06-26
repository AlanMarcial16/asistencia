<?php
// Archivo: alertas_salida.php

// Incluir la conexión a la base de datos
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
$sql = "SELECT ra.id, ra.id_empleado, ra.fecha, ra.hora_entrada, e.nombre 
        FROM registros_asistencia ra 
        INNER JOIN empleados e ON ra.id_empleado = e.id 
        WHERE ra.hora_salida IS NULL";
$result = $conn->query($sql);

$alertas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_registro = $row['id'];
        $nombre_empleado = $row['nombre'];
        $hora_entrada = $row['hora_entrada'];

        // Calcular hora límite para la salida (hora de entrada + 8 horas)
        $entrada_timestamp = strtotime($hora_entrada);
        $salida_timestamp = $entrada_timestamp + (8 * 3600);
        $hora_salida = date("H:i:s", $salida_timestamp);

        // Calcular hora para mostrar la alerta (10 minutos antes de la hora de salida)
        $alerta_timestamp = $salida_timestamp - (10 * 60);
        $hora_alerta = date("H:i:s", $alerta_timestamp);

        // Obtener la hora actual
        $hora_actual = date("H:i:s");

        // Solo agregar alerta si la hora actual es menor a la hora de alerta
        if ($hora_actual < $hora_alerta) {
            $alertas[] = [
                'nombre' => $nombre_empleado,
                'hora_alerta' => $hora_alerta,
                'hora_salida' => $hora_salida
            ];
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alertas de Salida</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
<?php if (!empty($alertas)) : ?>
    document.addEventListener("DOMContentLoaded", function() {
        <?php foreach ($alertas as $alerta) : ?>
            // Calcular el tiempo restante hasta la hora de alerta
            var ahora = new Date();
            var alertaHora = new Date();
            alertaHora.setHours(<?= date('H', strtotime($alerta['hora_alerta'])) ?>);
            alertaHora.setMinutes(<?= date('i', strtotime($alerta['hora_alerta'])) ?>);
            alertaHora.setSeconds(<?= date('s', strtotime($alerta['hora_alerta'])) ?>);
            
            var tiempoRestante = alertaHora - ahora;

            if (tiempoRestante > 0) {
                setTimeout(function() {
                    Swal.fire({
                        title: '¡Recordatorio!',
                        text: "Empleado <?= $alerta['nombre'] ?>, no olvide registrar su salida a las <?= $alerta['hora_salida'] ?>.",
                        icon: 'info',
                        confirmButtonText: 'Entendido'
                    });
                }, tiempoRestante);
            }
        <?php endforeach; ?>
    });
<?php endif; ?>
</script>
</body>
</html>
