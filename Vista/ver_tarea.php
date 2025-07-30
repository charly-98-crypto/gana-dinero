<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../Modelo/conexion.php");

$id = $_GET['id'] ?? 0;

$db = new Conexion();
$conn = $db->conectar();

$sql = "SELECT * FROM tareas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$tarea = $stmt->get_result()->fetch_assoc();

if (!$tarea) {
    echo "Tarea no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
        }
        .card {
            background-color: rgba(255,255,255,0.08);
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            margin: auto;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
        }
        a, .btn {
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #00ff88;
            color: black;
            font-weight: bold;
            border: none;
        }
    </style>
</head>
<body>

<div class="card">
    <h3>📌 <?php echo htmlspecialchars($tarea['descripcion']); ?></h3>
    <p>Haz clic en el botón de abajo para abrir el enlace de la tarea:</p>
    <a href="<?php echo htmlspecialchars($tarea['enlace']); ?>" target="_blank" class="btn btn-info">🔗 Ir al enlace</a>

    <form action="../Controlador/procesar_tarea.php" method="POST">
        <input type="hidden" name="descripcion" value="<?php echo htmlspecialchars($tarea['descripcion']); ?>">
        <input type="hidden" name="recompensa" value="<?php echo $tarea['recompensa']; ?>">
        <button type="submit" class="btn btn-primary mt-3">✅ Ya lo hice</button>
    </form>
</div>

</body>
</html>
