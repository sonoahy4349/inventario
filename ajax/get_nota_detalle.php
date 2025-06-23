<?php
require_once '../models/conexion.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$response = ['success' => false];

if ($id > 0) {
    $sql = "SELECT n.id, n.titulo, n.descripcion, n.fecha_creacion, n.hora_creacion,
                   e.numero_serie,
                   u.nombre_completo AS nombre_usuario
            FROM notas_equipos n
            LEFT JOIN equipos e ON n.equipo_id = e.id
            LEFT JOIN usuarios u ON n.usuario_id = u.id
            WHERE n.id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($nota = $result->fetch_assoc()) {
            $response['success'] = true;
            $response['nota'] = $nota;
        } else {
            $response['message'] = 'Nota no encontrada';
        }
    } else {
        $response['message'] = 'Error al preparar la consulta';
    }
} else {
    $response['message'] = 'ID de nota no válido';
}

echo json_encode($response);
?>
