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
        console.log('Contenido del código QR:', content); // Agregar esta línea para verificar el contenido del código QR
        var empleadoId = content; // El contenido del código QR es el ID del empleado
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().slice(0, 10);
        var formattedTime = ('0' + currentDate.getHours()).slice(-2) + ':' + ('0' + currentDate.getMinutes()).slice(-2) + ':' + ('0' + currentDate.getSeconds()).slice(-2);
        
        // Conectar a la base de datos
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText); // Muestra la respuesta del servidor en la consola
                // Mostrar mensaje de éxito o error según la respuesta del servidor
                if (this.responseText === 'success') {
                    alert('Registro de salida exitoso');
                    window.location.href = 'salida_opc.php';
                } else {
                    alert('Error al registrar la salida: ' + this.responseText);
                }
            }
        };
        xhttp.open("POST", "registrar_salida2.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + empleadoId + "&fecha=" + formattedDate + "&hora=" + formattedTime);
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
