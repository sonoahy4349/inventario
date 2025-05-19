<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helpdesk";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Elimina este echo: "Conexión exitosa" causa problemas con JSON
?>
