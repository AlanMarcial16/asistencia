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
            max-width: 1000px;
            padding: 20px;
            text-align: center;
        }

        .header {
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100%;
        }

        .content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section {
            flex: 1;
            text-align: center;
        }

        .section h2 {
            margin-bottom: 20px;
        }

        .button {
            padding: 20px;
            margin: 10px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 80%;
        }

        .button.primary {
            background-color: #4caf50;
            color: white;
        }

        .button.primary:hover {
            background-color: #45a049;
        }

        .button.secondary {
            background-color: #ffc107;
            color: white;
        }

        .button.secondary:hover {
            background-color: #e0a800;
        }

        .logo-container {
            flex: 0 1 40%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Registro de Asistencia</h1>
    </div>
    <br><br>
    <div class="content">
        <div class="section">
            <h2>Entrada</h2>
            <button class="button primary" onclick="location.href='entrada_opc.php';">Registrar Entrada</button>
        </div>
        <div class="logo-container">
            <img class="logo" src="https://static.wixstatic.com/media/9ed84f_e9388ac15d374e77aa9c89cdb80e014a~mv2.png" alt="Logo">
        </div>
        <div class="section">
            <h2>Salida</h2>
            <button class="button secondary" onclick="location.href='salida_opc.php';">Registrar Salida</button>
        </div>
    </div>
    <br><br>
</div>

</body>
</html>
