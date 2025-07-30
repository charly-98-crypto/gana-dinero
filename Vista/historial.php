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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#111; color:white; padding:20px;">
<h3 style="background: linear-gradient(to right, #00ffe0, #00c3ff); 
           padding: 12px 20px; 
           border-radius: 12px; 
           font-weight: bold; 
           color: black; 
           text-align: center; 
           box-shadow: 0 0 15px #00ffe0;
           margin-bottom: 30px;">
    🗂️ Historial completo de tareas realizadas
</h3>

<div style="text-align: center; margin: 20px 0;">
    <a href="panel.php" 
       style="display: inline-block;
              background: linear-gradient(to right, #00ffe0, #00c3ff);
              color: black;
              padding: 10px 25px;
              border-radius: 12px;
              font-weight: bold;
              font-size: 16px;
              text-decoration: none;
              box-shadow: 0 0 12px #00ffe0;
              transition: all 0.3s ease;">
       ⬅️ Volver al Panel
    </a>
</div>


    <table class="table table-dark table-bordered">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Recompensa</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT descripcion, recompensa, fecha FROM tareas_realizadas WHERE usuario = ? ORDER BY fecha DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['descripcion']) ?></td>
                <td>$<?= number_format($row['recompensa'], 2) ?></td>
                <td><?= $row['fecha'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
