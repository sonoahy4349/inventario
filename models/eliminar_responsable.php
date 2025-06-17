<?php
include_once 'conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

try {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id <= 0) {
        throw new Exception('ID de responsable inválido');
    }

    // Verificar si el responsable existe
    $stmt_check = $conn->prepare("SELECT id_responsable FROM responsable WHERE id_responsable = ?");
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows === 0) {
        throw new Exception('El responsable no existe');
    }

    // Verificar si el responsable está asignado a alguna estación
    $stmt_estaciones = $conn->prepare("SELECT id FROM estaciones WHERE responsable_id = ?");
    $stmt_estaciones->bind_param("i", $id);
    $stmt_estaciones->execute();
    $result_estaciones = $stmt_estaciones->get_result();

    if ($result_estaciones->num_rows > 0) {
        throw new Exception('No se puede eliminar el responsable porque está asignado a una o más estaciones');
    }

    // Eliminar el responsable
    $stmt_delete = $conn->prepare("DELETE FROM responsable WHERE id_responsable = ?");
    $stmt_delete->bind_param("i", $id);
    
    if ($stmt_delete->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Responsable eliminado exitosamente'
        ]);
    } else {
        throw new Exception('Error al eliminar el responsable');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>