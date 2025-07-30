<?php
require_once("../Modelo/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $telefono = $_POST['telefono'];

    // Encriptar la clave
    $clave_segura = password_hash($clave, PASSWORD_DEFAULT);

    // Bono de bienvenida
    $bono = 5.00;

    $db = new Conexion();
    $conn = $db->conectar();

    $sql = "INSERT INTO usuarios (usuario, correo, clave, telefono, saldo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssd", $usuario, $correo, $clave_segura, $telefono, $bono);

    if ($stmt->execute()) {
        // Redirigir al login con mensaje
        header("Location: ../login.php?registro=ok");
        exit();
    } else {
        echo "❌ Error al registrar: " . $conn->error;
    }
}
