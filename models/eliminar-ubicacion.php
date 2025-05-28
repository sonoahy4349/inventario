<?php
// eliminar-ubicacion.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        $conn = new mysqli("localhost", "root", "", "helpdesk");

        if ($conn->connect_error) {
            echo json_encode(["success" => false, "message" => "Conexión fallida"]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM ubicaciones WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "No se eliminó nada"]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "ID inválido"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
