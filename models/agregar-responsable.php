<?php
// Incluir la conexión
require_once '../config/conexion.php';

// Verificar que se recibieron los datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener y limpiar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $id_cargo = intval($_POST['id_cargo']);
    
    // Validar que todos los campos estén completos
    if (empty($nombre) || empty($apellidos) || $id_cargo <= 0) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Verificar que el cargo existe
        $stmt_check = $conn->prepare("SELECT COUNT(*) as count FROM cargos WHERE id_cargo = ?");
        $stmt_check->bind_param("i", $id_cargo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();
        
        if ($row_check['count'] == 0) {
            $error = "El cargo seleccionado no es válido.";
        } else {
            // Preparar la consulta de inserción
            $stmt = $conn->prepare("INSERT INTO responsable (nombre, apellidos, id_cargo) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $nombre, $apellidos, $id_cargo);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir de vuelta a la página anterior para recargarla
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                $error = "Error al agregar el responsable: " . $conn->error;
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
    
    // Cerrar conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Agregar Responsable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .result-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
        }
        .success {
            color: #27ae60;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .error {
            color: #e74c3c;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .btn {
            background-color: #3498db;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <?php if (isset($error)): ?>
            <div class="error">
                <h2>Error</h2>
                <p><?php echo $error; ?></p>
            </div>
            <a href="javascript:history.back()" class="btn">Volver</a>
            <a href="../index.php" class="btn">Ir al inicio</a>
        <?php endif; ?>
    </div>
</body>
</html>