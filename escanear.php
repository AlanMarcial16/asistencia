<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escaneo de Código QR</title>
    <!-- Agrega la biblioteca Instascan -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- Agrega la biblioteca SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        var year = currentDate.getFullYear();
        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2); // Agrega un cero delante si el mes es de un solo dígito
        var day = ('0' + currentDate.getDate()).slice(-2); // Agrega un cero delante si el día es de un solo dígito
        var hour = ('0' + currentDate.getHours()).slice(-2); // Agrega un cero delante si la hora es de un solo dígito
        var minute = ('0' + currentDate.getMinutes()).slice(-2); // Agrega un cero delante si el minuto es de un solo dígito
        var second = ('0' + currentDate.getSeconds()).slice(-2); // Agrega un cero delante si el segundo es de un solo dígito
        var formattedDate = year + '-' + month + '-' + day; // Formato YYYY-MM-DD
        var formattedTime = hour + ':' + minute + ':' + second; // Formato HH:MM:SS

        // Hacer una solicitud al servidor para obtener el nombre del empleado y los retardos
        fetch('obtenerEmpleado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                id: empleadoId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                Swal.fire({
                    title: 'Error',
                    text: data.error,
                    icon: 'error'
                });
                return;
            }

            var nombreEmpleado = data.nombre;
            var retardos = data.retardos;
            var retardosHtml = `<span style="color: ${retardos >= 1 ? 'red' : 'green'};">RETARDOS: ${retardos}</span>`;

            // Mostrar alerta de registro exitoso usando SweetAlert y redirigir después de 3 segundos
            Swal.fire({
                title: 'Registro Exitoso',
                html: `El registro de asistencia ha sido exitoso.<br>Empleado: <strong>${nombreEmpleado}</strong><br>${retardosHtml}`,
                icon: 'success',
                showConfirmButton: false,
                timer: 3000,
                willClose: () => {
                    // Redirigir a la página de registro de asistencia con el ID del empleado, la fecha y la hora actuales
                    window.location.href = 'http://localhost/asistencia/registrar_asistencia2.php?id=' + empleadoId + '&fecha=' + formattedDate + '&hora=' + formattedTime;
                }
            });
        })
        .catch(error => console.error('Error al obtener el nombre del empleado:', error));
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
