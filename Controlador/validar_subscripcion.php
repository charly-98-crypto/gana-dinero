<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../Modelo/conexion.php");

$usuario = $_SESSION['usuario'];
$db = new Conexion();
$conn = $db->conectar();

$sql = "UPDATE usuarios SET suscrito = 1 WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();

echo "<div style='padding: 30px; text-align: center;'>
        <h3>✅ ¡Suscripción activada con éxito!</h3>
        <p>Ahora puedes retirar tu dinero cuando quieras.</p>
        <a href='../Vista/panel.php' class='btn btn-primary mt-3'>Volver al panel</a>
      </div>";
?>
