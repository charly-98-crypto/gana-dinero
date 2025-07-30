<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['terminos'] = true;
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Términos y Condiciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/Zeus.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .terminos-box {
            background-color: rgba(0, 0, 0, 0.85);
            padding: 40px;
            border-radius: 15px;
            max-width: 700px;
            width: 90%;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }

        h2 {
            color: #00ffff;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-aceptar {
            background-color: #00ffcc;
            color: black;
            font-weight: bold;
            border-radius: 10px;
            width: 100%;
        }

        p {
            font-size: 15px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="terminos-box">
        <h2>Términos y Condiciones</h2>
        <p>Este sistema es una simulación educativa. No nos hacemos responsables por mal uso, interpretación o expectativas falsas.</p>
        <p>Al aceptar, confirmas que eres mayor de edad y que estás de acuerdo en usar esta plataforma bajo tu propia responsabilidad.</p>
        <p>No garantizamos pagos ni beneficios reales. Todas las tareas son con fines demostrativos.</p>
        <form method="POST">
            <button type="submit" class="btn btn-aceptar mt-3">Acepto los términos y condiciones</button>
        </form>
    </div>
</body>
</html>

