<?php
// Incluir conexión a la base de datos
include('conexion.php'); // Ajusta la ruta según tu estructura

try {
    // Datos de equipos (corregido según tu BD)
    $queryEquipos = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN ee.nombre = 'En uso' THEN 1 ELSE 0 END) as en_uso,
        SUM(CASE WHEN ee.nombre = 'Disponible' THEN 1 ELSE 0 END) as disponible,
        SUM(CASE WHEN ee.nombre = 'En mantenimiento' THEN 1 ELSE 0 END) as mantenimiento
        FROM equipos e
        INNER JOIN estados_equipo ee ON e.estado_id = ee.id";
    
    $resultEquipos = $conn->query($queryEquipos);
    $equiposData = $resultEquipos->fetch_assoc();
    
    $totalEquipos = $equiposData['total'];
    $equiposEnUso = $equiposData['en_uso'];
    $equiposDisponibles = $equiposData['disponible'];
    $equiposEnMantenimiento = $equiposData['mantenimiento'];

    // Datos de usuarios (usando tu tabla usuarios)
    $queryUsuarios = "SELECT 
        COUNT(*) as total_usuarios,
        SUM(CASE WHEN u.id IN (SELECT DISTINCT responsable_id FROM estaciones WHERE activo = TRUE) THEN 1 ELSE 0 END) as usuarios_con_equipos
        FROM usuarios u";
    
    $resultUsuarios = $conn->query($queryUsuarios);
    $usuariosData = $resultUsuarios->fetch_assoc();
    
    $totalUsuarios = $usuariosData['total_usuarios'];
    $usuariosAsignados = $usuariosData['usuarios_con_equipos'];

    // Datos de ubicaciones (usando tu estructura real)
    $queryEdificios = "SELECT COUNT(*) as total FROM edificios";
    $resultEdificios = $conn->query($queryEdificios);
    $edificios = $resultEdificios->fetch_assoc()['total'];

    $queryServicios = "SELECT COUNT(*) as total FROM servicios";
    $resultServicios = $conn->query($queryServicios);
    $servicios = $resultServicios->fetch_assoc()['total'];

    $queryUbicacionesInternas = "SELECT COUNT(*) as total FROM ubicaciones_internas";
    $resultUbicacionesInternas = $conn->query($queryUbicacionesInternas);
    $ubicaciones_internas = $resultUbicacionesInternas->fetch_assoc()['total'];

    $total = $edificios + $servicios + $ubicaciones_internas;

    // Datos de responsables (usando tu tabla responsable)
    $queryResponsables = "SELECT 
        COUNT(*) as total_responsables,
        SUM(CASE WHEN r.id_responsable IN (SELECT DISTINCT responsable_id FROM estaciones WHERE activo = TRUE) THEN 1 ELSE 0 END) as responsables_con_equipos
        FROM responsable r";
    
    $resultResponsables = $conn->query($queryResponsables);
    $responsablesData = $resultResponsables->fetch_assoc();
    
    $totalResponsables = $responsablesData['total_responsables'];
    $responsablesAsignados = $responsablesData['responsables_con_equipos'];

    // Datos para gráfica - Distribución de equipos por servicio (área)
    $queryDistribucion = "SELECT 
        s.nombre as area,
        COUNT(DISTINCT e.id) as cantidad_equipos
        FROM equipos e
        INNER JOIN estaciones est ON (e.id = est.equipo_principal_id OR e.id = est.equipo_secundario_id)
        INNER JOIN ubicaciones u ON est.ubicacion_id = u.id
        INNER JOIN servicios s ON u.servicio_id = s.id
        WHERE est.activo = TRUE
        GROUP BY s.id, s.nombre
        HAVING cantidad_equipos > 0
        ORDER BY cantidad_equipos DESC";
    
    $resultDistribucion = $conn->query($queryDistribucion);
    $distribucionData = [];
    
    while($row = $resultDistribucion->fetch_assoc()) {
        $distribucionData[] = [
            'area' => $row['area'],
            'cantidad' => (int)$row['cantidad_equipos']
        ];
    }
    
    // Si no hay datos de distribución, crear datos de ejemplo
    if (empty($distribucionData)) {
        $distribucionData = [
            ['area' => 'Administración', 'cantidad' => 2],
            ['area' => 'Sistemas', 'cantidad' => 1],
            ['area' => 'Recursos Humanos', 'cantidad' => 1]
        ];
    }
    
    // Convertir datos a JSON para usar en JavaScript
    $distribucionJSON = json_encode($distribucionData);

} catch (Exception $e) {
    // Valores por defecto en caso de error
    $totalEquipos = 0;
    $equiposEnUso = 0;
    $equiposDisponibles = 0;
    $equiposEnMantenimiento = 0;
    $totalUsuarios = 0;
    $usuariosAsignados = 0;
    $totalResponsables = 0;
    $responsablesAsignados = 0;
    $total = 0;
    $edificios = 0;
    $servicios = 0;
    $ubicaciones_internas = 0;
    $distribucionJSON = '[{"area":"Sin datos","cantidad":0}]';
    
    // Log del error para debug
    error_log("Error en inicio-controller.php: " . $e->getMessage());
}
?>