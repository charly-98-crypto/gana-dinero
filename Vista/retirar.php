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
$sql_saldo = "SELECT saldo, suscrito FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql_saldo);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$saldo = $row['saldo'] ?? 0;
$suscrito = $row['suscrito'] ?? 0;

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $metodo = $_POST['metodo'] ?? '';
    $destino = $_POST['destino'] ?? '';
    $monto = floatval($_POST['monto'] ?? 0);

    if ($monto > 0 && $monto <= $saldo && $suscrito) {
        $fecha = date("Y-m-d H:i:s");
        $sql_retirar = "INSERT INTO retiros (usuario, metodo, destino, monto, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt_ret = $conn->prepare($sql_retirar);
        $stmt_ret->bind_param("sssds", $usuario, $metodo, $destino, $monto, $fecha);
        $stmt_ret->execute();

        $conn->query("UPDATE usuarios SET saldo = saldo - $monto WHERE usuario = '$usuario'");

        $mensaje = "✅ Retiro solicitado correctamente. Será procesado pronto.";
        $saldo -= $monto;
    } elseif (!$suscrito) {
        $mensaje = "❌ Debes estar suscrito para retirar. Suscríbete primero.";
    } else {
        $mensaje = "❌ Saldo insuficiente o monto inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Retirar Dinero</title>
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
        .btn-retirar {
            background: linear-gradient(to right, #00ff88, #00c3ff);
            color: black;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            box-shadow: 0 0 10px #00ff88;
        }
        input, select {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 10px;
            width: 100%;
            margin-bottom: 15px;
        }
        input::placeholder, select {
            color: #ccc;
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
    <h3 class="text-center">💸 Retirar Dinero</h3>
    <p class="text-center">💰 Saldo disponible: <strong>$<?php echo number_format($saldo, 2); ?> USD</strong></p>

    <?php if ($mensaje): ?>
        <div class="alert alert-info text-center"> <?php echo $mensaje; ?> </div>
    <?php endif; ?>

    <form method="POST">
        <select name="metodo" id="metodo" onchange="autocompletarDestino()" required>
            <option value="">Selecciona método de pago</option>
            <option value="Nequi">Nequi</option>
            <option value="PayPal">PayPal</option>
            <option value="Bancolombia">Bancolombia</option>
        </select>
        <input type="text" name="destino" id="destino" placeholder="Número o correo del destino" required>
        <input type="number" name="monto" placeholder="Monto a retirar" min="1" step="0.01" required>
        <button type="submit" class="btn-retirar">💳 Solicitar Retiro</button>
    </form>
        <div class="text-center mt-3">
<a href="historial_retiros.php" class="text-info">📄 Ver historial de retiros</a>
    </div>

    <div class="text-center mt-3">
        <a href="panel.php" class="text-info">⬅️ Volver al panel</a>
    </div>
</div>
</body>
</html>
