<?php
include 'conexion.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $responsable_id = intval($_GET['id']);
    
    $sql = "SELECT 
                c.nombre_cargo as cargo
            FROM responsable r
            LEFT JOIN cargos c ON r.id_cargo = c.id_cargo
            WHERE r.id_responsable = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $responsable_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Responsable no encontrado']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}

$conn->close();
?>