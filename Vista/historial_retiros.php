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

$sql = "SELECT monto, metodo_pago, estado, fecha FROM solicitudes_retiro WHERE usuario = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Retiros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/img/Zeus.png') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            margin: 0;
            padding: 0;
        }

        /* Capa oscura encima de la imagen */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.7); /* oscuridad encima */
            z-index: 0;
        }

        .contenedor {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: auto;
            margin-top: 40px;
            background-color: rgba(255,255,255,0.05);
            padding: 30px;
            border-radius: 15px;
            color: white;
        }

        table {
            background-color: rgba(255,255,255,0.05);
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

        .logo-container {
            text-align: center;
            margin-top: 30px;
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 150px;
        }
    </style>
</head>
<body>

<div class="logo-container">
    <img src="../assets/img/logo.png" class="logo" alt="Logo">
</div>

<div class="contenedor">
    <h2 class="mb-4 text-center">💸 Historial de Retiros</h2>

    <table class="table table-striped table-bordered text-white">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Monto</th>
                <th>Método de Pago</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 1;
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>{$contador}</td>
                        <td>$" . number_format($row['monto'], 2) . "</td>
                        <td>" . htmlspecialchars($row['metodo_pago']) . "</td>
                        <td>" . htmlspecialchars($row['estado']) . "</td>
                        <td>" . date('d/m/Y H:i', strtotime($row['fecha'])) . "</td>
                      </tr>";
                $contador++;
            }
            ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="panel.php" class="btn btn-volver">🔙 Volver al panel</a>
    </div>
</div>

</body>
</html>
