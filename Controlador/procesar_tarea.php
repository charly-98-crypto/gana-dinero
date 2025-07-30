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
$tarea_id = $_POST['id_tarea'] ?? null;

if (!$tarea_id) {
    echo "ID de tarea inválido";
    exit();
}

$hoy = date("Y-m-d");
$ip = $_SERVER['REMOTE_ADDR'];
$navegador = $_SERVER['HTTP_USER_AGENT'];

// Verificar si ya hizo esta tarea hoy
$sql_check = "SELECT * FROM tareas_realizadas WHERE usuario = ? AND tarea_id = ? AND fecha = ?";
$stmt_check = $conn->prepare($sql_check);
if (!$stmt_check) {
    die("❌ Error en prepare() de sql_check: " . $conn->error);
}
$stmt_check->bind_param("sis", $usuario, $tarea_id, $hoy);
$stmt_check->execute();
$res_check = $stmt_check->get_result();

if ($res_check->num_rows > 0) {
    echo "<script>alert('⚠️ Ya realizaste esta tarea hoy.'); window.location.href = '../Vista/panel.php';</script>";
    exit();
}

// Obtener recompensa y descripción desde tareas
$sql_tarea = "SELECT recompensa, descripcion FROM tareas WHERE id = ?";
$stmt_tarea = $conn->prepare($sql_tarea);
if (!$stmt_tarea) {
    die("❌ Error en prepare() de sql_tarea: " . $conn->error);
}
$stmt_tarea->bind_param("i", $tarea_id);
$stmt_tarea->execute();
$res_tarea = $stmt_tarea->get_result();
$row_tarea = $res_tarea->fetch_assoc();

$recompensa = $row_tarea['recompensa'] ?? 0;
$descripcion = $row_tarea['descripcion'] ?? '';

// Sumar estrellas al usuario
$sql_update = "UPDATE usuarios SET estrellas = estrellas + ? WHERE usuario = ?";
$stmt_update = $conn->prepare($sql_update);
if (!$stmt_update) {
    die("❌ Error en prepare() de sql_update: " . $conn->error);
}
$stmt_update->bind_param("ds", $recompensa, $usuario);
$stmt_update->execute();

// Registrar tarea realizada
$sql_insert = "INSERT INTO tareas_realizadas (tarea_id, usuario, descripcion, recompensa, fecha, ip_usuario, navegador)
               VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
if (!$stmt_insert) {
    die("❌ Error en prepare() de sql_insert: " . $conn->error);
}
$stmt_insert->bind_param("issdsss", $tarea_id, $usuario, $descripcion, $recompensa, $hoy, $ip, $navegador);
$stmt_insert->execute();

echo "<script>alert('✅ Tarea registrada. Ganaste $recompensa ⭐ estrellas'); window.location.href = '../Vista/panel.php';</script>";
?>
