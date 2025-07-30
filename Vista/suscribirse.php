<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

$usuario = $_SESSION['usuario']['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Suscripción Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Fondo con imagen Zeus y overlay oscuro */
    body {
        background: url('../assets/img/Zeus.png') no-repeat center center fixed;
        background-size: cover;
        position: relative;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
        color: white;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.7); /* Capa oscura */
        z-index: 0;
    }

    .container, .contenedor {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 50px auto;
        background-color: rgba(255, 255, 255, 0.05);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
    }

    .payment-box {
        background-color: transparent;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-pago {
        width: 100%;
        background-color: #00ff88;
        color: black;
        font-weight: bold;
        border-radius: 10px;
        padding: 10px;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: 10px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 15px rgba(0, 255, 136, 0.3);
    }

    .btn-pago:hover {
        background-color: #00cc70;
        transform: scale(1.02);
    }

    .btn-disabled {
        background-color: #555;
        color: #999;
        pointer-events: none;
    }

    .text-center {
        text-align: center;
    }

    .logo {
        width: 150px;
        display: block;
        margin: 30px auto 10px auto;
        position: relative;
        z-index: 1;
    }
</style>

</head>
<body>

<div class="container">
    <h3 class="text-center mb-4">🔓 Suscripción Premium</h3>
    <p>Para activar los retiros, paga <strong>$215.000 COP - 50 USD</strong> usando uno de estos métodos:</p>

    <!-- Nequi -->
    <div class="payment-box">
        <h5>📱 Nequi</h5>
        <p>Paga a: <strong>3122909856</strong></p>
        <a href="https://wa.me/573156184427?text=Hola%2C+ya+realic%C3%A9+el+pag%C3%B3+para+mi+suscripci%C3%B3n+en+Gana+Dinero+Real" 
           target="_blank" class="btn-pago">✅ Confirmar pago por WhatsApp</a>
    </div>

    <!-- PayPal -->
    <div class="payment-box">
        <h5>💻 PayPal</h5>
        <p>Correo: <strong>oneidasaldarriaga301@gmail.com</strong></p>
        <a href="https:/paypal.me/Oneida258?country.x=CO&locale.x=es_XC" 
           target="_blank" class="btn-pago">💳 Ir a pagar con PayPal</a>
    </div>

    <!-- Bancolombia -->
    <div class="payment-box">
        <h5>🏦 Bancolombia</h5>
        <p><em>Próximamente disponible</em></p>
        <a href="#" class="btn-pago btn-disabled">🚫 No disponible</a>
    </div>

    <!-- Confirmación -->
    <form action="../Controlador/procesar_suscripcion.php" method="POST">
        <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
        <button type="submit" class="btn-pago">✅ Ya pagué, activar cuenta</button>
    </form>

 <div class="text-center mt-3">
        <a href="panel.php" class="text-info">⬅️ Volver al panel</a>
    </div>
</body>
</html>
