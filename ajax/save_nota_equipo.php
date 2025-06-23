<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Inicializar respuesta
$response = array(
    'success' => false,
    'message' => '',
    'nota_id' => null
);

try {
    // Solo aceptar peticiones POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Solo se permiten peticiones POST');
    }
    
    // Incluir conexión a base de datos
    // Ajusta esta ruta según tu estructura
    require_once '../models/conexion.php'; // o el archivo donde tengas tu conexión
    
    // Verificar que se enviaron todos los datos necesarios
    if (!isset($_POST['equipo_id']) || !is_numeric($_POST['equipo_id'])) {
        throw new Exception('ID de equipo no válido');
    }
    
    if (!isset($_POST['usuario_id']) || !is_numeric($_POST['usuario_id'])) {
        throw new Exception('ID de usuario no válido');
    }
    
    if (!isset($_POST['titulo']) || trim($_POST['titulo']) === '') {
        throw new Exception('El título es obligatorio');
    }
    
    $equipo_id = (int)$_POST['equipo_id'];
    $usuario_id = (int)$_POST['usuario_id'];
    $titulo = trim($_POST['titulo']);
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    
    // Validaciones adicionales
    if ($equipo_id <= 0) {
        throw new Exception('ID de equipo debe ser mayor a 0');
    }
    
    if ($usuario_id <= 0) {
        throw new Exception('ID de usuario debe ser mayor a 0');
    }
    
    if (strlen($titulo) > 255) {
        throw new Exception('El título no puede tener más de 255 caracteres');
    }
    
    if (strlen($descripcion) > 5000) {
        throw new Exception('La descripción no puede tener más de 5000 caracteres');
    }
    
    // Verificar que el equipo existe
    $sql_check = "SELECT id FROM equipos WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    if (!$stmt_check) {
        throw new Exception('Error al verificar equipo: ' . $conn->error);
    }
    
    $stmt_check->bind_param("i", $equipo_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows === 0) {
        throw new Exception('El equipo especificado no existe');
    }
    $stmt_check->close();
    
    // Preparar consulta de inserción
    $sql = "INSERT INTO notas_equipos (equipo_id, usuario_id, titulo, descripcion, fecha_creacion, hora_creacion) 
            VALUES (?, ?, ?, ?, CURDATE(), CURTIME())";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Error en preparación de consulta: ' . $conn->error);
    }
    
    $stmt->bind_param("iiss", $equipo_id, $usuario_id, $titulo, $descripcion);
    
    if (!$stmt->execute()) {
        throw new Exception('Error al guardar la nota: ' . $stmt->error);
    }
    
    $nota_id = $conn->insert_id;
    $stmt->close();
    
    $response['success'] = true;
    $response['nota_id'] = $nota_id;
    $response['message'] = 'Nota guardada correctamente';
    
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    
    // Log del error para debugging
    error_log("Error en save_nota_equipo.php: " . $e->getMessage());
}

// Enviar respuesta JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit();
?>