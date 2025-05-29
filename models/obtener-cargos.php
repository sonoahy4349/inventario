<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Incluir la conexión
require_once '../models/conexion.php';

// Consulta para obtener todos los cargos
$sql = "SELECT id_cargo, nombre_cargo FROM cargos ORDER BY nombre_cargo";
$result = $conn->query($sql);

$cargos = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cargos[] = $row;
    }
}

// Devolver los cargos en formato JSON
echo json_encode($cargos);

// Cerrar conexión
$conn->close();
?>