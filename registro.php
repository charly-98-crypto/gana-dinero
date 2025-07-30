<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cuenta</title>
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

        .register-box {
            background-color: #0b0b0b;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
            width: 100%;
            max-width: 420px;
            color: white;
        }

        .register-box img {
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

        .btn-register {
            background-color: #00ffcc;
            color: black;
            font-weight: bold;
            border-radius: 10px;
        }

        a {
            color: #00ffff;
        }

        h2 {
            text-align: center;
            color: #00ffff;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <img src="assets/img/logo.png" alt="Logo">
        <h2>Crear una cuenta</h2>
        <form action="Controlador/registrar_usuario.php" method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ej: carlos123" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" name="correo" id="correo" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="3101234567" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="clave" id="clave" placeholder="********" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-register">Registrarme</button>
            </div>
        </form>
        <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
    
</body>

</html>