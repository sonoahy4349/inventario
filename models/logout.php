<?php
// logout.php
session_start();        // Inicia o recupera la sesión

// 1. Vaciar todas las variables de sesión
$_SESSION = [];

// 2. Destruir la cookie de sesión (opcional, pero recomendable)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destruir la sesión en el servidor
session_destroy();

// 4. Redirigir al login
header("Location: ../index.html");   // Ajusta la ruta
exit;
