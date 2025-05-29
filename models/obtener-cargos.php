<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helpdesk"; // Cambia por "helpdesk" si es necesario

try {
    // Crear conexión PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta para obtener todos los cargos
    $stmt = $pdo->prepare("SELECT id_cargo, nombre_cargo FROM cargos ORDER BY nombre_cargo");
    $stmt->execute();
    
    $cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Devolver los cargos en formato JSON
    echo json_encode($cargos);
    
} catch(PDOException $e) {
    // En caso de error, devolver mensaje de error
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener cargos: ' . $e->getMessage()]);
}
?>