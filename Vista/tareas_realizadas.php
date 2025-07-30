<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../Modelo/conexion.php");
$usuario = $_SESSION['usuario']['usuario'];

$db = new Conexion();
$conn = $db->conectar();

$sql = "SELECT descripcion, recompensa, fecha FROM tareas_realizadas WHERE usuario = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
        }
        .contenedor {
            max-width: 800px;
            margin: auto;
            background-color: rgba(255,255,255,0.05);
            padding: 30px;
            border-radius: 15px;
        }
        .btn-volver {
            background-color: #00ff88;
            color: black;
            font-weight: bold;
            border-radius: 10px;
            text-decoration: none;
        }
        .btn-volver:hover {
            background-color: #00cc70;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <h2 class="mb-4 text-center">📋 Historial de Tareas Realizadas</h2>
    <ul class="list-group">
        <?php
        while ($row = $resultado->fetch_assoc()) {
            echo "<li class='list-group-item list-group-item-dark'>
                <strong>" . htmlspecialchars($row['descripcion']) . "</strong>
                (+$" . number_format($row['recompensa'], 2) . ") – " . date('d/m/Y H:i', strtotime($row['fecha'])) . "
            </li>";
        }
        ?>
    </ul>
    <div class="text-center mt-4">
        <a href="panel.php" class="btn btn-volver">🔙 Volver al panel</a>
    </div>
</div>

</body>
</html>
