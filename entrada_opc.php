<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia</title>
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

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
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
        <h1>Registro de Asistencia - Entrada</h1>
        <div class="button-container">
            <button class="button primary" onclick="location.href='escanear.php';">Registro con QR</button>
            <button class="button secondary" onclick="location.href='form.php';">Registro con Formulario</button>
        </div>
    </div>
</div>

</body>
</html>
