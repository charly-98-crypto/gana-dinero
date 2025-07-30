<?php
require_once("../Modelo/conexion.php");
session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$db = new Conexion();
$conn = $db->conectar();

$sql = "SELECT * FROM usuarios WHERE usuario = ? OR correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {
    $fila = $resultado->fetch_assoc();
    if (password_verify($clave, $fila['clave'])) {
        $_SESSION['usuario'] = $fila;

        if ($fila['terminos_aceptados'] == 1) {
            header("Location: ../Vista/panel.php");
        } else {
            header("Location: ../terminos.php");
        }
        exit();
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado";
}
?>
