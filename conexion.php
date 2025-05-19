<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // Cambia si tienes password
$base_de_datos = "inventario";

$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
