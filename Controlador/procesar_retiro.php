<?php
session_start();
require_once("../Modelo/conexion.php");

// 1. Validar sesión y obtener el nombre de usuario
if (!isset($_SESSION['usuario']) || !is_array($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
$usuario = $_SESSION['usuario']['usuario'];

// 2. Recibir datos del formulario
$metodo  = $_POST['metodo']  ?? '';
$destino = $_POST['destino'] ?? '';
$monto   = floatval($_POST['monto'] ?? 0);

$db   = new Conexion();
$conn = $db->conectar();

// 3. Verificar suscripción y saldo
$sql  = "SELECT suscrito, saldo FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$res    = $stmt->get_result();
$datos  = $res->fetch_assoc();

// Si no encontró al usuario o no es array
if (!$datos) {
    echo "⚠️ Usuario no encontrado.";
    exit();
}

// Validar suscripción
if (intval($datos['suscrito']) !== 1) {
    echo "⚠️ No estás suscrito para retirar.";
    exit();
}

// Validar monto
$saldo_actual = floatval($datos['saldo']);
if ($monto <= 0 || $monto > $saldo_actual) {
    echo "⚠️ Monto inválido. Verifica tu saldo.";
    exit();
}

// 4. Descontar del saldo
$nuevo_saldo = $saldo_actual - $monto;
$sql2 = "UPDATE usuarios SET saldo = ? WHERE usuario = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ds", $nuevo_saldo, $usuario);
$stmt2->execute();

// 5. (Opcional) Aquí podrías guardar un registro de retiro en otra tabla

// 6. Actualizar sesión
$_SESSION['usuario']['saldo'] = $nuevo_saldo;

// 7. Confirmación
echo "<div style='padding:30px;text-align:center;color:white;'>
        <h3>✅ Retiro solicitado con éxito</h3>
        <p>Monto: <strong>$$monto USD</strong></p>
        <p>Método: $metodo</p>
        <p>Destino: $destino</p>
        <a href='../Vista/panel.php' class='btn btn-primary mt-3'>Volver al panel</a>
      </div>";
