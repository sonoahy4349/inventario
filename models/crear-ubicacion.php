<?php
include 'conexion.php';

// Configurar el tipo de contenido como JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $edificio_nombre = trim($_POST['edificio_nombre']);
    $numero_plantas = intval($_POST['numero_plantas']);
    $servicio_nombre = trim($_POST['servicio_nombre']);
    $ubicacion_interna_nombre = trim($_POST['ubicacion_interna_nombre']);
    $planta_especifica = intval($_POST['planta_especifica']);
    
    // Validar que todos los campos requeridos estén presentes
    if (empty($edificio_nombre) || $numero_plantas <= 0 || empty($servicio_nombre) || empty($ubicacion_interna_nombre) || $planta_especifica < 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Todos los campos son requeridos y deben ser válidos'
        ]);
        exit;
    }
    
    // Validar que la planta específica no sea mayor al número de plantas
    if ($planta_especifica >= $numero_plantas) {
        echo json_encode([
            'status' => 'error',
            'message' => 'La planta específica no puede ser mayor o igual al número total de plantas'
        ]);
        exit;
    }
    
    // Iniciar transacción
    $conn->begin_transaction();
    
    try {
        // 1. Verificar si el edificio ya existe, si no, crearlo
        $sql_check_edificio = "SELECT id FROM edificios WHERE nombre = ?";
        $stmt_check = $conn->prepare($sql_check_edificio);
        $stmt_check->bind_param("s", $edificio_nombre);
        $stmt_check->execute();
        $result_edificio = $stmt_check->get_result();
        
        if ($result_edificio->num_rows > 0) {
            $edificio_id = $result_edificio->fetch_assoc()['id'];
        } else {
            $sql_edificio = "INSERT INTO edificios (nombre, numero_plantas) VALUES (?, ?)";
            $stmt_edificio = $conn->prepare($sql_edificio);
            $stmt_edificio->bind_param("si", $edificio_nombre, $numero_plantas);
            $stmt_edificio->execute();
            $edificio_id = $conn->insert_id;

            $sql_planta = "INSERT INTO plantas (edificio_id, numero_planta, nombre) VALUES (?, ?, ?)";
            $stmt_planta = $conn->prepare($sql_planta);

            $planta_nombre = "Planta Baja";
            $numero_cero = 0;
            $stmt_planta->bind_param("iis", $edificio_id, $numero_cero, $planta_nombre);
            $stmt_planta->execute();

            for ($i = 1; $i < $numero_plantas; $i++) {
                $planta_nombre = "Piso " . $i;
                $stmt_planta->bind_param("iis", $edificio_id, $i, $planta_nombre);
                $stmt_planta->execute();
            }
        }

        // 2. Verificar si el servicio ya existe, si no, crearlo
        $sql_check_servicio = "SELECT id FROM servicios WHERE nombre = ?";
        $stmt_check_serv = $conn->prepare($sql_check_servicio);
        $stmt_check_serv->bind_param("s", $servicio_nombre);
        $stmt_check_serv->execute();
        $result_servicio = $stmt_check_serv->get_result();

        if ($result_servicio->num_rows > 0) {
            $servicio_id = $result_servicio->fetch_assoc()['id'];
        } else {
            $sql_servicio = "INSERT INTO servicios (nombre) VALUES (?)";
            $stmt_servicio = $conn->prepare($sql_servicio);
            $stmt_servicio->bind_param("s", $servicio_nombre);
            $stmt_servicio->execute();
            $servicio_id = $conn->insert_id;
        }

        // 3. Verificar si la ubicación interna ya existe, si no, crearla
        $sql_check_ubicacion = "SELECT id FROM ubicaciones_internas WHERE nombre = ?";
        $stmt_check_ubi = $conn->prepare($sql_check_ubicacion);
        $stmt_check_ubi->bind_param("s", $ubicacion_interna_nombre);
        $stmt_check_ubi->execute();
        $result_ubicacion = $stmt_check_ubi->get_result();

        if ($result_ubicacion->num_rows > 0) {
            $ubicacion_interna_id = $result_ubicacion->fetch_assoc()['id'];
        } else {
            $sql_ubicacion_interna = "INSERT INTO ubicaciones_internas (nombre) VALUES (?)";
            $stmt_ubicacion_interna = $conn->prepare($sql_ubicacion_interna);
            $stmt_ubicacion_interna->bind_param("s", $ubicacion_interna_nombre);
            $stmt_ubicacion_interna->execute();
            $ubicacion_interna_id = $conn->insert_id;
        }

        // 4. Obtener el ID de la planta específica
        $sql_get_planta = "SELECT id FROM plantas WHERE edificio_id = ? AND numero_planta = ?";
        $stmt_get_planta = $conn->prepare($sql_get_planta);
        $stmt_get_planta->bind_param("ii", $edificio_id, $planta_especifica);
        $stmt_get_planta->execute();
        $result_planta = $stmt_get_planta->get_result();
        $row_planta = $result_planta->fetch_assoc();

        if (!$row_planta) {
            throw new Exception("No se encontró la planta especificada para el edificio.");
        }

        $planta_id = $row_planta['id'];

        // 5. Verificar que no exista ya esta combinación de ubicación
        $sql_check_final = "SELECT id FROM ubicaciones WHERE edificio_id = ? AND planta_id = ? AND servicio_id = ? AND ubicacion_interna_id = ?";
        $stmt_check_final = $conn->prepare($sql_check_final);
        $stmt_check_final->bind_param("iiii", $edificio_id, $planta_id, $servicio_id, $ubicacion_interna_id);
        $stmt_check_final->execute();
        $result_final = $stmt_check_final->get_result();

        if ($result_final->num_rows > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Esta ubicación ya existe.'
            ]);
            $conn->rollback();
            exit;
        }

        // 6. Insertar nueva ubicación
        $sql_insert_ubicacion = "INSERT INTO ubicaciones (edificio_id, planta_id, servicio_id, ubicacion_interna_id) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert_ubicacion);
        $stmt_insert->bind_param("iiii", $edificio_id, $planta_id, $servicio_id, $ubicacion_interna_id);
        $stmt_insert->execute();

        // Confirmar la transacción
        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Ubicación creada correctamente'
        ]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al crear ubicación: ' . $e->getMessage()
        ]);
    }
}
?>
