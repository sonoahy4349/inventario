<?php
require_once '../models/conexion.php'; // Ajusta la ruta si es diferente

header('Content-Type: application/json');

$equipo_id = isset($_GET['equipo_id']) ? intval($_GET['equipo_id']) : 0;

$response = ['success' => false, 'notas' => []];

if ($equipo_id > 0) {
    $sql = "SELECT n.id, n.titulo, n.fecha_creacion, n.hora_creacion
            FROM notas_equipos n
            WHERE n.equipo_id = ?
            ORDER BY n.fecha_creacion DESC, n.hora_creacion DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $equipo_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $notas = [];
        while ($row = $result->fetch_assoc()) {
            $notas[] = $row;
        }

        $response['success'] = true;
        $response['notas'] = $notas;
    } else {
        $response['message'] = 'Error al preparar la consulta';
    }
} else {
    $response['message'] = 'ID de equipo no válido';
}

echo json_encode($response);
?>
