<?php
include_once 'conexion.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT id_cargo, nombre_cargo FROM cargos ORDER BY nombre_cargo ASC";
    $result = $conn->query($sql);

    $cargos = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cargos[] = $row;
        }
    }

    echo json_encode([
        'success' => true,
        'data' => $cargos
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener cargos: ' . $e->getMessage()
    ]);
}

$conn->close();
?>