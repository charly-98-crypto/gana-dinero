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
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <style>
        body {
            background: url('../assets/img/Zeus.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
        }
        .panel {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 20px;
            color: white;
            max-width: 700px;
            margin: 40px auto;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
        }
        .btn-pago {
            background-color: #00ff88;
            color: black;
            font-weight: bold;
            width: 100%;
            border-radius: 12px;
            text-align: center;
            display: inline-block;
            padding: 12px;
            text-decoration: none;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: none;
            color: white;
        }
        .form-control::placeholder {
            color: #ccc;
        }
        .form-check-label {
            font-weight: 500;
        }
        .saldo-box {
            background: #111;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            color: #00ff88;
        }
    </style>
</head>
<body>

<div class="panel">
    <h4 class="text-center mb-4">🚀 Inversión de Dinero</h4>

    <div class="saldo-box">
        💰 Saldo disponible: $<?php echo number_format($saldo, 2); ?> USD
    </div>

    <form action="../Controlador/procesar_inversion.php" method="POST">
        <label class="form-label">Selecciona una opción:</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="opcion" value="Visibilidad - 2.00" required>
            <label class="form-check-label">🚀 Aumentar visibilidad de mi perfil — <strong>$2.00 USD</strong></label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="opcion" value="Tareas promocionales - 3.50">
            <label class="form-check-label">📈 Comprar tareas promocionales — <strong>$3.50 USD</strong></label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="opcion" value="Destacar contenido - 2.50">
            <label class="form-check-label">🌟 Promocionar mi contenido en portada — <strong>$2.50 USD</strong></label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="opcion" value="Referidos premium - 2.00">
            <label class="form-check-label">👥 Activar sistema de referidos — <strong>$2.00 USD</strong></label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="opcion" value="Más ganancia por tarea - 1.75">
            <label class="form-check-label">💸 Mejorar ganancia por tarea — <strong>$1.75 USD</strong></label>
        </div>

        <div class="mb-3">
            <label class="form-label">📩 ¿Otra idea personalizada?</label>
            <textarea name="comentario" class="form-control" rows="3" placeholder="Describe tu inversión personalizada..."></textarea>
            <div class="mt-2 text-warning small">Para inversiones personalizadas escríbenos directamente a WhatsApp: <a href="https://wa.me/573156184427" target="_blank">315 618 4427</a></div>
        </div>

        <a href="https://www.paypal.me/Oneida258" class="btn-pago" target="_blank">💳 Pagar con PayPal</a>
    </form>
</div>

</body>
</html>
