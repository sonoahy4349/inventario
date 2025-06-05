<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo     = $_POST['username'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    if (empty($correo) || empty($contrasena)) {
        header('Location: index.php?error=Correo+y+contraseña+son+requeridos');
        exit;
    }

    try {
        $sql = "SELECT usuarios.id, usuarios.nombre_completo, roles.nombre AS rol_nombre
                FROM usuarios
                JOIN roles ON usuarios.rol_id = roles.id
                WHERE usuarios.correo = ? AND usuarios.contrasena = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta');
        }

        $stmt->bind_param("ss", $correo, $contrasena);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['nombre_completo'];
            $_SESSION['user_role'] = $user['rol_nombre']; // <-- nombre del rol

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
    header('Location: index.php');
    exit;
}


