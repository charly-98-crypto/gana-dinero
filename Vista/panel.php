<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../Modelo/conexion.php");

$db = new Conexion();
$conn = $db->conectar();

$usuario = $_SESSION['usuario']['usuario'] ?? '';

// Obtener saldo del usuario
$sql = "SELECT saldo FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$saldo = $row['saldo'] ?? 0;

?>
<?php
require_once("../Modelo/conexion.php");
$db = new Conexion();
$conn = $db->conectar();

$usuario = $_SESSION['usuario']['usuario'];

// Obtener estrellas
$sql_stars = "SELECT estrellas FROM usuarios WHERE usuario = ?";
$stmt_stars = $conn->prepare($sql_stars);
$stmt_stars->bind_param("s", $usuario);
$stmt_stars->execute();
$res_stars = $stmt_stars->get_result();
$row_stars = $res_stars->fetch_assoc();

$estrellas = $row_stars['estrellas'] ?? 0;

// Conversión
$tasa_conversion = 120;
$equivalente_usd = $estrellas / $tasa_conversion;
?>

<?php
// Obtener estado de suscripción
$sql_sub = "SELECT suscrito FROM usuarios WHERE usuario = ?";
$stmt_sub = $conn->prepare($sql_sub);
if (!$stmt_sub) {
    die("❌ Error en prepare() de sql_sub: " . $conn->error);
}
$stmt_sub->bind_param("s", $usuario);
$stmt_sub->execute();
$res_sub = $stmt_sub->get_result();
$row_sub = $res_sub->fetch_assoc();

$suscrito = $row_sub['suscrito'] ?? 0;
?>

<?php if ($suscrito == 1): ?>
    <div style="text-align: center; margin-top: 20px;">
        <a href="convertir.php" style="
            display: inline-block;
            background: linear-gradient(to right, #00ffff, #00c3ff);
            padding: 12px 25px;
            font-weight: bold;
            color: black;
            border-radius: 12px;
            box-shadow: 0 0 12px #00ff88;
            text-decoration: none;
        ">
            🔁 Convertir estrellas a dólares
        </a>
    </div>
<?php else: ?>
    <div style="text-align: center; margin-top: 25px;">
        <p style=" color:rgb(238, 255, 0);">⚠️ Debes estar suscrito para convertir tus estrellas</p>
        <a href="suscribirse.php" class="btn btn-primary fw-bold rounded-pill px-4 py-2">
  💳 Suscribirse Ahora
</a>
    </div>
<?php endif; ?>

</div>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - Gana Dinero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/img/Zeus.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }

        .header {
            background: rgba(0,0,0,0.8);
            padding: 20px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            border-bottom: 2px solid #00ffcc;
        }

        .panel {
            max-width: 950px;
            margin: 40px auto;
            background: rgba(0, 0, 0, 0.85);
            padding: 30px;
            border-radius: 15px;
        }

        .usuario-info {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .usuario-info img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .usuario-info .nombre {
            font-size: 20px;
        }

        .saldo {
            font-size: 18px;
            color: #00ff88;
            font-weight: bold;
        }

    .tarea {
    background: rgba(255, 255, 255, 0.1); /* oscuro semitransparente */
    color: white;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    backdrop-filter: blur(3px); /* efecto de desenfoque elegante */
}

.tarea h5 {
    font-weight: bold;
    color: #00ffff;
}

.tarea p {
    margin: 5px 0;
}

.tarea img {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    margin-right: 15px;
    border: 2px solid #00ff88;
}


        .acciones {
            text-align: center;
            margin-top: 30px;
        }

        .acciones a {
            margin: 10px;
            padding: 10px 20px;
            background-color: #00ff88;
            border-radius: 10px;
            color: black;
            font-weight: bold;
            text-decoration: none;
        }

        .acciones a:hover {
            background-color: #00cc70;
        }

        .btn-sm {
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php
$nombreUsuario = $_SESSION['usuario']['usuario'];
?>
<div class="top-bar d-flex justify-content-between align-items-center px-4 py-2" style="background: #111; color: white; position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
    
    <!-- Logo + nombre -->
    <div class="d-flex align-items-center">
        <img src="../assets/img/logo.png" alt="Logo" style="height: 40px; margin-right: 10px;">
        <strong>Bienvenido, <?php echo ucfirst($usuario); ?> 👋</strong>
    </div>

    <!-- Opciones del menú -->
    <div class="d-flex gap-3 align-items-center">
        <a href="retirar.php" class="btn btn-sm btn-success">💸 Retirar</a>
        <a href="invertir.php" class="btn btn-sm btn-info text-white">📈 Invertir</a>
        <a href="https://wa.me/573156184427?text=Hola%2C+necesito+soporte+con+mi+cuenta+de+Gana+Dinero+Real" target="_blank" class="btn btn-sm btn-warning text-dark">💬 Soporte Tecnico</a>
        <a href="https://wa.me/573156184427?text=Hola%2C+quiero+más+información+sobre+Gana+Dinero+Real" target="_blank" class="btn btn-sm btn-outline-light">📞 Contactanos</a>
        <a href="../Controlador/logout.php" class="btn btn-sm btn-danger">🚪 Cerrar sesión</a>
    </div>
</div>




<div style="
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(6px);
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 0 18px #00ffff;
    margin: 40px auto 30px;
    max-width: 600px;
">
    <h4 style="color: #00ffff; font-size: 24px; font-weight: bold;">
        🌟 Estrellas acumuladas: <?php echo $estrellas; ?>
    </h4>
    <p style="color: #ffffff; font-size: 18px; margin-top: 10px;">
        💵 Equivale a: <strong>$<?php echo number_format($equivalente_usd, 2); ?> USD</strong><br>
        <small style="color: #bbb;">(Tasa actual: 120 ⭐ = 1 USD)</small>
    </p>
</div>

    <?php
    $sql = "SELECT * FROM tareas ORDER BY id ASC LIMIT 10";
    $res = $conn->query($sql);

    if (!$res) {
        echo "<div class='alert alert-danger'>Error al cargar tareas: " . $conn->error . "</div>";
    } else {
        while ($row = $res->fetch_assoc()):
    ?>
        <div class="tarea">
            <img src="../assets/img/<?= htmlspecialchars($row['imagen']) ?>" alt="Tarea">
            <div style="flex: 1;">
                <h5><?= htmlspecialchars($row['descripcion']) ?></h5>
                <p><?= htmlspecialchars($row['descripcion']) ?></p>
                <a href="<?= htmlspecialchars($row['enlace']) ?>" target="_blank" class="btn btn-info btn-sm mb-2">🔗 Ir a la tarea</a>
                <form action="../Controlador/procesar_tarea.php" method="POST" class="d-inline">
                    <input type="hidden" name="id_tarea" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-success btn-sm">✅ Ya la hice</button>
                </form>
            </div>
        </div>
    <?php
        endwhile;
    }
    ?>




<h4 style="background: linear-gradient(to right, #00ffe0, #00c3ff); 
           padding: 12px 20px; 
           border-radius: 12px; 
           font-weight: bold; 
           color: black; 
           text-align: center; 
           box-shadow: 0 0 15px #00ffe0;
           margin-bottom: 25px;">
    📜 Últimas tareas realizadas
</h4>

<?php
$sql_hist = "SELECT descripcion, recompensa, fecha FROM tareas_realizadas 
             WHERE usuario = ? ORDER BY fecha DESC LIMIT 5";
$stmt_hist = $conn->prepare($sql_hist);
$stmt_hist->bind_param("s", $usuario);
$stmt_hist->execute();
$res_hist = $stmt_hist->get_result();

if ($res_hist->num_rows > 0) {
    echo "<ul class='list-group'>";
    while ($row = $res_hist->fetch_assoc()) {
        echo "<li class='list-group-item bg-dark text-white'>";
        echo "✅ " . htmlspecialchars($row['descripcion']) . " — <strong>$" . number_format($row['recompensa'], 2) . "</strong> el " . $row['fecha'];
        echo "</li>";
    }
    echo "</ul>";
    echo "<div style='text-align: center; margin-top: 25px;'>
            <a href='historial.php' 
               style='display: inline-block;
                      background: linear-gradient(to right, #00ffe0, #00c3ff);
                      color: black;
                      padding: 10px 25px;
                      border-radius: 12px;
                      font-weight: bold;
                      font-size: 16px;
                      text-decoration: none;
                      box-shadow: 0 0 12px #00ffe0;
                      transition: all 0.3s ease;'>
               📂 Ver historial completo
            </a>
         </div>";
} else {
    echo "<p class='text-white text-center'>Aún no has realizado ninguna tarea.</p>";
}
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

