<?php
include 'conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'crear') {
        // CREAR UBICACIÓN
        $edificio_nombre = trim($_POST['edificio_nombre']);
        $numero_plantas = intval($_POST['numero_plantas']);
        $servicio_nombre = trim($_POST['servicio_nombre']);
        $ubicacion_interna_nombre = trim($_POST['ubicacion_interna_nombre']);
        $planta_especifica = intval($_POST['planta_especifica']);

        if (empty($edificio_nombre) || $numero_plantas <= 0 || empty($servicio_nombre) || empty($ubicacion_interna_nombre) || $planta_especifica < 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Todos los campos son requeridos y deben ser válidos'
            ]);
            exit;
        }

        if ($planta_especifica >= $numero_plantas) {
            echo json_encode([
                'status' => 'error',
                'message' => 'La planta específica no puede ser mayor o igual al número total de plantas'
            ]);
            exit;
        }

        $conn->begin_transaction();

        try {
            // 1. EDIFICIO
            $stmt = $conn->prepare("SELECT id FROM edificios WHERE nombre = ?");
            $stmt->bind_param("s", $edificio_nombre);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $edificio_id = $result->fetch_assoc()['id'];
            } else {
                $stmt = $conn->prepare("INSERT INTO edificios (nombre, numero_plantas) VALUES (?, ?)");
                $stmt->bind_param("si", $edificio_nombre, $numero_plantas);
                $stmt->execute();
                $edificio_id = $conn->insert_id;

                $stmt_planta = $conn->prepare("INSERT INTO plantas (edificio_id, numero_planta, nombre) VALUES (?, ?, ?)");
                for ($i = 0; $i < $numero_plantas; $i++) {
                    $planta_nombre = ($i == 0) ? "Planta Baja" : "Piso $i";
                    $stmt_planta->bind_param("iis", $edificio_id, $i, $planta_nombre);
                    $stmt_planta->execute();
                }
            }

            // 2. SERVICIO
            $stmt = $conn->prepare("SELECT id FROM servicios WHERE nombre = ?");
            $stmt->bind_param("s", $servicio_nombre);
            $stmt->execute();
            $result = $stmt->get_result();
            $servicio_id = ($result->num_rows > 0) ? $result->fetch_assoc()['id'] : null;

            if (!$servicio_id) {
                $stmt = $conn->prepare("INSERT INTO servicios (nombre) VALUES (?)");
                $stmt->bind_param("s", $servicio_nombre);
                $stmt->execute();
                $servicio_id = $conn->insert_id;
            }

            // 3. UBICACIÓN INTERNA
            $stmt = $conn->prepare("SELECT id FROM ubicaciones_internas WHERE nombre = ?");
            $stmt->bind_param("s", $ubicacion_interna_nombre);
            $stmt->execute();
            $result = $stmt->get_result();
            $ubicacion_interna_id = ($result->num_rows > 0) ? $result->fetch_assoc()['id'] : null;

            if (!$ubicacion_interna_id) {
                $stmt = $conn->prepare("INSERT INTO ubicaciones_internas (nombre) VALUES (?)");
                $stmt->bind_param("s", $ubicacion_interna_nombre);
                $stmt->execute();
                $ubicacion_interna_id = $conn->insert_id;
            }

            // 4. PLANTA
            $stmt = $conn->prepare("SELECT id FROM plantas WHERE edificio_id = ? AND numero_planta = ?");
            $stmt->bind_param("ii", $edificio_id, $planta_especifica);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result->num_rows) {
                throw new Exception("No se encontró la planta especificada para el edificio.");
            }

            $planta_id = $result->fetch_assoc()['id'];

            // 5. VERIFICAR DUPLICADO
            $stmt = $conn->prepare("SELECT id FROM ubicaciones WHERE edificio_id = ? AND planta_id = ? AND servicio_id = ? AND ubicacion_interna_id = ?");
            $stmt->bind_param("iiii", $edificio_id, $planta_id, $servicio_id, $ubicacion_interna_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $conn->rollback();
                echo json_encode(['status' => 'error', 'message' => 'Esta ubicación ya existe.']);
                exit;
            }

            // 6. INSERTAR UBICACIÓN
            $stmt = $conn->prepare("INSERT INTO ubicaciones (edificio_id, planta_id, servicio_id, ubicacion_interna_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $edificio_id, $planta_id, $servicio_id, $ubicacion_interna_id);
            $stmt->execute();

            $conn->commit();
            echo json_encode(['status' => 'success', 'message' => 'Ubicación creada correctamente']);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Error al crear ubicación: ' . $e->getMessage()]);
        }

    } elseif ($action === 'eliminar') {
        // ELIMINAR UBICACIÓN
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM ubicaciones WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(["status" => "success", "message" => "Ubicación eliminada correctamente"]);
            } else {
                echo json_encode(["status" => "error", "message" => "No se eliminó ninguna ubicación"]);
            }

            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "ID inválido"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Acción no reconocida"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
