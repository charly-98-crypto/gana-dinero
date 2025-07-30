<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: Vista/panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/img/Zeus.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #0b0b0b;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
            width: 100%;
            max-width: 420px;
            color: white;
        }

        .login-box img {
            display: block;
            margin: 0 auto 20px;
            height: 80px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .btn-login {
            background-color: #00ffcc;
            color: black;
            font-weight: bold;
            border-radius: 10px;
        }

        a {
            color: #00ffff;
        }

        .alert {
            font-size: 14px;
        }

        h2 {
            text-align: center;
            color: #00ffff;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <img src="assets/img/logo.png" alt="Logo">

        <?php if (isset($_GET['registro']) && $_GET['registro'] == 'ok'): ?>
            <div class="alert alert-success text-center mb-3">
                ✅ ¡Registro exitoso! Ahora inicia sesión con tus datos.
            </div>
        <?php endif; ?>

        <h2>Iniciar Sesión</h2>
        <form action="Controlador/verificar_login.php" method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario o correo</label>
                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Tu usuario o email" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="clave" id="clave" placeholder="********" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-login">Ingresar</button>
            </div>
        </form>
        <p class="text-center mt-3">¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
    </div>
</body>
</html>
