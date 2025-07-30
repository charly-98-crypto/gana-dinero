<?php
session_start();
require_once("../Modelo/conexion.php");

// 1. Validar sesión y obtener usuario
if (!isset($_SESSION['usuario']) || !is_array($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
$usuario = $_SESSION['usuario']['usuario'];

// 2. Recoger el monto a invertir
$monto = floatval($_POST['monto'] ?? 0);

$db   = new Conexion();
$conn = $db->conectar();

// 3. Obtener saldo actual
$sql  = "SELECT saldo FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$res   = $stmt->get_result();
$dato  = $res->fetch_assoc();

if (!$dato) {
    echo "⚠️ Usuario no encontrado.";
    exit();
}

$saldo = floatval($dato['saldo']);
if ($monto <= 0 || $monto > $saldo) {
    echo "⚠️ Monto inválido.";
    exit();
}

// 4. Restar el monto invertido
$nuevo_saldo = $saldo - $monto;
$sql2 = "UPDATE usuarios SET saldo = ? WHERE usuario = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ds", $nuevo_saldo, $usuario);
$stmt2->execute();

// 5. (Opcional) Aquí podrías guardar registro de inversión

// 6. Actualizar sesión
$_SESSION['usuario']['saldo'] = $nuevo_saldo;

// 7. Mostrar confirmación
echo "<div style='padding:30px;text-align:center;color:white;'>
        <h3>✅ Inversión realizada</h3>
        <p>Monto invertido: <strong>$$monto USD</strong></p>
        <p>Saldo restante: <strong>$$nuevo_saldo USD</strong></p>
        <a href='../Vista/panel.php' class='btn btn-primary mt-3'>Volver al panel</a>
      </div>";
