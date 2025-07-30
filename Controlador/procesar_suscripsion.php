<?php
require_once("../Modelo/conexion.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

$usuario = $_SESSION['usuario']['usuario'];

$db = new Conexion();
$conn = $db->conectar();

// Activar suscripción (simulado manualmente)
$sql = "UPDATE usuarios SET suscripcion = 1 WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();

echo "<script>alert('✅ Suscripción activada. Ahora puedes retirar.'); window.location.href = '../Vista/panel.php';</script>";
