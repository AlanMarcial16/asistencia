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
        console.log('Contenido del código QR:', content); // Agregar esta línea para verificar el contenido del código QR
        var empleadoId = content; // El contenido del código QR es el ID del empleado
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().slice(0, 10);
        var formattedTime = ('0' + currentDate.getHours()).slice(-2) + ':' + ('0' + currentDate.getMinutes()).slice(-2) + ':' + ('0' + currentDate.getSeconds()).slice(-2);
        
        // Hacer una solicitud al servidor para obtener el nombre del empleado
        fetch('obtenerEmpleado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                id: empleadoId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            var nombreEmpleado = data.nombre;

            // Enviar la solicitud para registrar la salida
            fetch('registrar_salida2.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    id: empleadoId,
                    fecha: formattedDate,
                    hora: formattedTime
                })
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'success') {
                    // Mostrar alerta de registro exitoso usando SweetAlert y redirigir después de 3 segundos
                    Swal.fire({
                        title: 'Registro Exitoso',
                        html: `El registro de salida ha sido exitoso.<br>Empleado: <strong>${nombreEmpleado}</strong>`,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                        willClose: () => {
                            // Redirigir a la página de salida después de 3 segundos
                            window.location.href = 'index.php';
                        }
                    });
                } else {
                    throw new Error(result);
                }
            })
            .catch(error => {
                console.error('Error al registrar la salida:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar la salida: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        })
        .catch(error => {
            console.error('Error al obtener el nombre del empleado:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error al obtener el nombre del empleado: ' + error.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
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
