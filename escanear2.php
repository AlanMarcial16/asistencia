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
    // Inicializa Instascan y comienza a escuchar los códigos QR
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
        var empleadoId = content; // El contenido del código QR es el ID del empleado
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().slice(0, 10);
        var formattedTime = ('0' + currentDate.getHours()).slice(-2) + ':' + ('0' + currentDate.getMinutes()).slice(-2) + ':' + ('0' + currentDate.getSeconds()).slice(-2);
        // Redirigir a la página de registro de asistencia con el ID del empleado, fecha y hora actuales
        window.location.href = 'http://localhost/asistencia/registrar_asistencia2.php?id=' + empleadoId + '&fecha=' + formattedDate + '&hora=' + formattedTime;
        // Mostrar alerta de registro exitoso
        alert("Registro exitoso");
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
