<?php
class Conexion {
    private $host = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $base_datos = "gana_dinero";
    public $conn;

    public function conectar() {
        $this->conn = new mysqli($this->host, $this->usuario, $this->clave, $this->base_datos);
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
?>
