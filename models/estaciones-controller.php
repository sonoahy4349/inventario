<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    
    if ($accion == 'agregar') {
        $equipo_principal_id = intval($_POST['equipo_principal_id']);
        $equipo_secundario_id = !empty($_POST['equipo_secundario_id']) ? intval($_POST['equipo_secundario_id']) : null;
        $ubicacion_id = intval($_POST['ubicacion_id']);
        $responsable_id = intval($_POST['responsable_id']);
        
        // Validar que el equipo principal no esté ya en uso
        $check_sql = "SELECT COUNT(*) as count FROM estaciones 
                      WHERE (equipo_principal_id = ? OR equipo_secundario_id = ?) 
                      AND activo = 1";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $equipo_principal_id, $equipo_principal_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_row = $check_result->fetch_assoc();
        
        if ($check_row['count'] > 0) {
            echo "<script>alert('Error: El equipo principal ya está asignado a otra estación.'); window.history.back();</script>";
            exit;
        }
        
        // Validar equipo secundario si se proporcionó
        if ($equipo_secundario_id) {
            $check_stmt->bind_param("ii", $equipo_secundario_id, $equipo_secundario_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $check_row = $check_result->fetch_assoc();
            
            if ($check_row['count'] > 0) {
                echo "<script>alert('Error: El equipo secundario ya está asignado a otra estación.'); window.history.back();</script>";
                exit;
            }
            
            // Validar que no sean el mismo equipo
            if ($equipo_principal_id == $equipo_secundario_id) {
                echo "<script>alert('Error: No puedes seleccionar el mismo equipo como principal y secundario.'); window.history.back();</script>";
                exit;
            }
        }
        
        // Insertar la nueva estación
        if ($equipo_secundario_id) {
            $sql = "INSERT INTO estaciones (equipo_principal_id, equipo_secundario_id, ubicacion_id, responsable_id) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiii", $equipo_principal_id, $equipo_secundario_id, $ubicacion_id, $responsable_id);
        } else {
            $sql = "INSERT INTO estaciones (equipo_principal_id, ubicacion_id, responsable_id) 
                    VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $equipo_principal_id, $ubicacion_id, $responsable_id);
        }
        
        if ($stmt->execute()) {
            echo "<script>alert('Estación agregada exitosamente'); window.location.href='../pages/estaciones.php';</script>";
        } else {
            echo "<script>alert('Error al agregar la estación: " . $conn->error . "'); window.history.back();</script>";
        }
        
        $stmt->close();
        $check_stmt->close();
    }
}

$conn->close();
