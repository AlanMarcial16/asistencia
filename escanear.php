<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escaneo de Código QR</title>
    <!-- Agrega la biblioteca Instascan -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body>

<h1>Escaneo de Código QR</h1>

<!-- Agrega un elemento de video para mostrar la vista de la cámara -->
<video id="preview"></video>

<!-- Agrega cualquier script JavaScript que necesites -->
<script>
    // Función para generar el contenido del código QR con la fecha y la hora actual
    function generateQRContent(empleadoId) {
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().slice(0, 10);
        var formattedTime = currentDate.getHours().toString().padStart(2, '0') + ':' + currentDate.getMinutes().toString().padStart(2, '0');
        return empleadoId + '-' + formattedDate + '-' + formattedTime;
    }

    // Inicializa Instascan y comienza a escuchar los códigos QR
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
        // Parsear el contenido del código QR para obtener el ID del empleado, la fecha y la hora
        var scanData = content.split('-');
        var empleadoId = scanData[0];
        var fecha = scanData[1];
        var hora = scanData[2];
        // Redirigir a la página de registro de asistencia con los datos del escaneo
        window.location.href = 'http://localhost/asistencia/registrar_asistencia2.php?id=' + empleadoId + '&fecha=' + fecha + '&hora=' + hora;
    });

    // Inicia el escaneo de códigos QR
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]); // Usa la primera cámara encontrada
        } else {
            console.error('No se encontraron cámaras.');
        }
    }).catch(function (e) {
        console.error(e);
    });
</script>


</body>
</html>
