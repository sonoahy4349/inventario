<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // Validación adicional si se desea...

    // Eliminar relaciones primero si las hay (por FK)
    $conn->query("DELETE FROM ticket_equipos WHERE equipo_id = $id");

    $sql = "DELETE FROM equipos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
?>
