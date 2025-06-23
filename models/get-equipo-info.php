<?php
include 'conexion.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $equipo_id = intval($_GET['id']);
    
    $sql = "SELECT 
                e.modelo,
                e.numero_serie,
                et.nombre as tipo,
                em.nombre as marca
            FROM equipos e
            LEFT JOIN equipo_tipo et ON e.tipo_id = et.id
            LEFT JOIN equipo_marca em ON e.marca_id = em.id
            WHERE e.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $equipo_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Equipo no encontrado']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}

$conn->close();
