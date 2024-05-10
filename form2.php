<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia - Salida</title>
    <!-- Agregamos la librería de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1000px; /* Ajustamos el ancho máximo */
            display: flex;
            overflow: hidden;
            padding: 20px;
        }

        .logo-container {
            flex: 1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-container img {
            max-width: 100%;
            max-height: 100%;
        }

        .form-container {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: left;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        select,
        input[type="date"],
        input[type="time"],
        input[type="submit"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: calc(100% - 22px);
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            padding: 15px 30px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button.primary {
            background-color: #4caf50;
            color: white;
        }

        .button.secondary {
            background-color: #008CBA;
            color: white;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="logo-container">
        <!-- Añadimos un elemento img dentro del contenedor -->
        <img src="https://static.wixstatic.com/media/9ed84f_e9388ac15d374e77aa9c89cdb80e014a~mv2.png" alt="Logo">
    </div>
    <div class="form-container">
        <h1>Registro de Asistencia Salida</h1>
        <br><br>
        <!-- Formulario -->
        <form id="asistencia-salida-form" action="registrar_salida.php" method="post">
            <label for="nombre">Empleado:</label>
            <select id="nombre" name="nombre" required>
                <option value="" selected disabled>Selecciona un empleado</option>
                <?php
                // Conexión a la base de datos
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "prueba";

                // Crear conexión
                $conn = new mysqli($servername, $username, $password, $database);

                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Obtener los nombres de los empleados de la base de datos
                $sql = "SELECT id, nombre FROM empleados";
                $result = $conn->query($sql);

                // Mostrar opciones en el selector
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nombre"] . '</option>';
                    }
                }
                ?>
            </select>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <input type="hidden" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>">
            <label for="hora_salida">Hora de Salida:</label>
            <input type="time" id="hora_salida" name="hora_salida" required readonly>
            <input type="submit" value="Registrar Salida">
        </form>
        <div class="button-container">
            <button class="button secondary" onclick="location.href='salida_opc.php';">Regresar</button>
        </div>
    </div>
</div>

<script>
// Obtener la hora actual
var horaActual = new Date().toLocaleTimeString('es-MX', {hour: '2-digit', minute: '2-digit', hour12: false});
// Llenar el campo de hora de salida automáticamente
document.getElementById('hora_salida').value = horaActual;

// Agregamos el listener para el evento change del selector de empleados
document.getElementById('nombre').addEventListener('change', function() {
    // Actualizar la hora de salida cuando se cambie el empleado
    var horaActual = new Date().toLocaleTimeString('es-MX', {hour: '2-digit', minute: '2-digit', hour12: false});
    // Llenar el campo de hora de salida automáticamente
    document.getElementById('hora_salida').value = horaActual;
});

// Agregamos el listener para el evento submit del formulario
document.getElementById('asistencia-salida-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    // Verificamos la contraseña
    var contrasena = document.getElementById('contrasena').value;
    if (contrasena === 'password123') { // Aquí deberías tener una forma segura de verificar la contraseña
        // Mostrar mensaje de éxito con retraso
        setTimeout(function() {
            Swal.fire({
                icon: 'success',
                title: 'Salida registrada',
                showConfirmButton: false,
                timer: 1500 // Cambia el valor del temporizador según tu preferencia
            }).then(function() {
                // Enviamos el formulario después del retraso
                document.getElementById('asistencia-salida-form').submit();
            });
        }, 500); // Retrasar la aparición del mensaje por 0.5 segundos
    } else {
        // Mostrar mensaje de error
        alert('Contraseña incorrecta');
    }
});
</script>

</body>
</html>
