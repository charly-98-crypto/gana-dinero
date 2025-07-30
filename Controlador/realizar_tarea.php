<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../Modelo/conexion.php");

$usuario = $_SESSION['usuario'];
$descripcion = $_POST['descripcion'];
$recompensa = floatval($_POST['recompensa']);

$db = new Conexion();
$conn = $db->conectar();

// Actualizar saldo
$sql1 = "UPDATE usuarios SET saldo = saldo + ? WHERE usuario = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("ds", $recompensa, $usuario);
$stmt1->execute();

// Registrar tarea realizada
$sql2 = "INSERT INTO tareas_realizadas (usuario, descripcion, recompensa) VALUES (?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("ssd", $usuario, $descripcion, $recompensa);
$stmt2->execute();

header("Location: ../Vista/panel.php");
exit();
?>
