<?php
include 'conexion.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $ubicacion_id = intval($_GET['id']);
    
    $sql = "SELECT 
                ed.nombre as edificio,
                p.nombre as planta,
                COALESCE(s.nombre, 'Sin servicio') as servicio,
                ui.nombre as ubicacion_interna
            FROM ubicaciones u
            LEFT JOIN edificios ed ON u.edificio_id = ed.id
            LEFT JOIN plantas p ON u.planta_id = p.id
            LEFT JOIN servicios s ON u.servicio_id = s.id
            LEFT JOIN ubicaciones_internas ui ON u.ubicacion_interna_id = ui.id
            WHERE u.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ubicacion_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Ubicación no encontrada']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}

$conn->close();
?>