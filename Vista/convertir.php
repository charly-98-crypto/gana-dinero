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

// Obtener estrellas actuales
$sql = "SELECT estrellas FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$estrellas = $row['estrellas'] ?? 0;

$mensaje = "";
$valor_usd = $estrellas / 100;
$comision = 0;
$total_recibir = $valor_usd;

if ($estrellas >= 500 && $estrellas <= 999) {
    $comision = $valor_usd * 0.10;
    $total_recibir = $valor_usd - $comision;
} elseif ($estrellas >= 1000) {
    $comision = $valor_usd * 0.12;
    $total_recibir = $valor_usd - $comision;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];
    $navegador = $_SERVER['HTTP_USER_AGENT'];

    // Registrar conversión
    $sql_hist = "INSERT INTO conversiones (usuario, estrellas, recompensa, fecha, ip_usuario, navegador) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_hist = $conn->prepare($sql_hist);
    $stmt_hist->bind_param("sidsss", $usuario, $estrellas, $total_recibir, $fecha, $ip, $navegador);
    $stmt_hist->execute();

    // Sumar al saldo y reiniciar estrellas
    $sql_sumar = "UPDATE usuarios SET saldo = saldo + ?, estrellas = 0 WHERE usuario = ?";
    $stmt_sumar = $conn->prepare($sql_sumar);
    $stmt_sumar->bind_param("ds", $total_recibir, $usuario);
    $stmt_sumar->execute();

    echo "<script>alert('🎉 Conversión exitosa. Se sumaron $$total_recibir USD a tu monedero.'); window.location.href = 'panel.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Convertir Estrellas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/img/zeus.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }
        .container-box {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px #00ff88;
            max-width: 600px;
            margin: 80px auto;
        }
        .btn-convertir {
            background: linear-gradient(to right, #00ff88, #00c3ff);
            color: black;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            box-shadow: 0 0 10px #00ff88;
        }
        input {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 10px;
            width: 100%;
            margin-bottom: 15px;
        }
        .logo {
            display: block;
            margin: 0 auto 15px;
            max-width: 120px;
            box-shadow: 0 0 20px #00ff88;
        }
    </style>
</head>
<body>
<div class="container-box">
    <img src="../assets/img/logo.png" class="logo" alt="Logo">
    <h3 class="text-center">💱 Convertir estrellas a dólares</h3>
    <p class="text-center">⭐ Estrellas actuales: <strong><?php echo $estrellas; ?></strong></p>
    <p class="text-center">💵 Equivalente: <strong>$<?php echo number_format($valor_usd, 2); ?> USD</strong></p>
    <p class="text-center text-warning">💸 Comisión: <strong>$<?php echo number_format($comision, 2); ?></strong></p>
    <p class="text-center text-success">✅ Total a recibir: <strong>$<?php echo number_format($total_recibir, 2); ?></strong></p>

    <form method="POST">
        <input type="hidden" name="confirmar" value="1">
        <button type="submit" class="btn-convertir d-block mx-auto">✅ Confirmar Conversión</button>
    </form>

    <div class="text-center mt-3">
        <a href="panel.php" class="text-info">⬅️ Volver al panel</a>
    </div>
</div>
</body>
</html>

