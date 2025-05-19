<?php
session_start();
require_once 'conexion.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo     = $_POST['username'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    // Validaciones básicas
    if (empty($correo) || empty($contrasena)) {
        header('Location: index.php?error=Correo+y+contraseña+son+requeridos');
        exit;
    }

    try {
        // Consulta preparada para seguridad
        $sql  = "SELECT id, nombre_completo, rol_id
                 FROM usuarios
                 WHERE correo = ? AND contrasena = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta');
        }

        $stmt->bind_param("ss", $correo, $contrasena);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Usuario autenticado correctamente
            $user = $result->fetch_assoc();

            // Guardar datos en sesión
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['nombre_completo'];
            $_SESSION['user_role'] = $user['rol_id'];

            // Redirigir al dashboard
            header('Location: /inventario/views/inicio.php');
            exit;

        } else {
            header('Location: index.php?error=Credenciales+incorrectas');
            exit;
        }
    } catch (Exception $e) {
        header('Location: index.php?error=Error+en+el+servidor');
        exit;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
} else {
    // Si alguien intenta acceder directamente al script
    header('Location: index.php');
    exit;
}
?>
