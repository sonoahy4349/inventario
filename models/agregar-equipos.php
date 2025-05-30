<?php
include '../models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_id = $_POST["tipo_id"];
    $marca_id = $_POST["marca_id"];
    $modelo = $_POST["modelo"];
    $numero_serie = $_POST["numero_serie"];
    $estado_id = $_POST["estado_id"];

    // Validación simple
    if (empty($tipo_id) || empty($marca_id) || empty($modelo) || empty($numero_serie) || empty($estado_id)) {
        die("Todos los campos son obligatorios.");
    }

    $stmt = $conn->prepare("INSERT INTO equipos (tipo_id, marca_id, modelo, numero_serie, estado_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissi", $tipo_id, $marca_id, $modelo, $numero_serie, $estado_id);

    if ($stmt->execute()) {
        header("Location: ../views/equipos.php?success=1");
        // Redirigir a la página de equipos con un mensaje de éxito
        exit();
    } else {
        echo "Error al agregar equipo: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
