<?php
header('Content-Type: application/json');

// Incluir conexión a la base de datos
require_once '../models/conexion.php'; // Ajusta la ruta según tu estructura

try {
    $equipo_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($equipo_id <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'ID de equipo no válido'
        ]);
        exit;
    }
    
    $sql = "SELECT e.*, et.nombre as tipo_nombre, em.nombre as marca_nombre 
            FROM equipos e 
            LEFT JOIN equipo_tipo et ON e.tipo_id = et.id 
            LEFT JOIN equipo_marca em ON e.marca_id = em.id 
            WHERE e.id = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conn->error);
    }
    
    $stmt->bind_param("i", $equipo_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Equipo no encontrado'
        ]);
        $stmt->close();
        exit;
    }
    
    $equipo = $result->fetch_assoc();
    $stmt->close();
    
    echo json_encode([
        'success' => true,
        'equipo' => [
            'id' => $equipo['id'],
            'tipo_nombre' => $equipo['tipo_nombre'] ?? 'N/A',
            'marca_nombre' => $equipo['marca_nombre'] ?? 'N/A',
            'modelo' => $equipo['modelo'] ?? 'N/A',
            'numero_serie' => $equipo['numero_serie'] ?? 'N/A'
        ]
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>