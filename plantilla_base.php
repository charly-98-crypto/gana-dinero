<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../Modelo/conexion.php");
$db = new Conexion();
$conn = $db->conectar();

$usuario = $_SESSION['usuario']['usuario'];

// Obtener saldo actual
$sql = "SELECT saldo FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$saldo = $row['saldo'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Invertir Dinero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../img/zeus.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }
        .overlay {
            background: rgba(0, 0, 0, 0.75);
            min-height: 100vh;
            padding-top: 50px;
        }
        .container-box {
            background-color: rgba(255,255,255,0.05);
            padding: 30px;
            border-radius: 20px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
        }
        .btn-custom {
            background-color: #00ff88;
            color: black;
            font-weight: bold;
            border-radius: 12px;
            width: 100%;
        }
        .logo {
            display: block;
            margin: 0 auto 25px auto;
            height: 70px;
        }
        h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .form-control, .form-label {
            background: transparent;
            color: white;
            border: none;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <img src="../img/logo.png" alt="Logo" class="logo">

        <div class="container-box">
            <h3>📈 Invertir Dinero</h3>

            <p class="text-center mb-4"><strong>Tu saldo actual:</strong> $<?php echo number_format($saldo, 2); ?> USD</p>

            <form action="../Controlador/procesar_inversion.php" method="POST">
                <div class="mb-3">
                    <label for="monto" class="form-label">¿Cuánto deseas invertir?</label>
                    <input type="number" name="monto" id="monto" step="0.01" max="<?php echo $saldo; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="comentario" class="form-label">¿En qué deseas invertir? (opcional)</label>
                    <textarea name="comentario" id="comentario" class="form-control" rows="3" placeholder="Ej: Comprar más tareas, publicidad, etc."></textarea>
                </div>
                <button type="submit" class="btn btn-custom">🚀 Enviar inversión</button>
            </form>
        </div>
    </div>
</body>
</html>
