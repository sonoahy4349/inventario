<?php
include_once 'conexion.php';

header('Content-Type: application/json');

try {
    // Obtener parámetros
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $registros_por_pagina = isset($_GET['registros_por_pagina']) ? (int)$_GET['registros_por_pagina'] : 10;
    $filtro = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
    $cargo_filtro = isset($_GET['cargo']) ? (int)$_GET['cargo'] : 0;

    // Calcular offset
    $offset = ($pagina - 1) * $registros_por_pagina;

    // Construir la consulta base
    $sql_base = "SELECT r.id_responsable, r.nombre, r.apellidos, r.id_cargo, c.nombre_cargo 
                 FROM responsable r 
                 LEFT JOIN cargos c ON r.id_cargo = c.id_cargo";
    
    $sql_count = "SELECT COUNT(*) as total FROM responsable r 
                  LEFT JOIN cargos c ON r.id_cargo = c.id_cargo";
    
    $where_conditions = [];
    $params = [];
    $types = "";

    // Aplicar filtros
    if (!empty($filtro)) {
        $where_conditions[] = "(r.nombre LIKE ? OR r.apellidos LIKE ?)";
        $filtro_param = "%$filtro%";
        $params[] = $filtro_param;
        $params[] = $filtro_param;
        $types .= "ss";
    }

    if ($cargo_filtro > 0) {
        $where_conditions[] = "r.id_cargo = ?";
        $params[] = $cargo_filtro;
        $types .= "i";
    }

    // Construir WHERE clause
    $where_clause = "";
    if (!empty($where_conditions)) {
        $where_clause = " WHERE " . implode(" AND ", $where_conditions);
    }

    // Consulta para contar total de registros
    $stmt_count = $conn->prepare($sql_count . $where_clause);
    if (!empty($params)) {
        $stmt_count->bind_param($types, ...$params);
    }
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $total_registros = $result_count->fetch_assoc()['total'];

    // Consulta para obtener los datos paginados
    $sql_data = $sql_base . $where_clause . " ORDER BY r.id_responsable ASC LIMIT ? OFFSET ?";
    $params[] = $registros_por_pagina;
    $params[] = $offset;
    $types .= "ii";

    $stmt = $conn->prepare($sql_data);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $responsables = [];
    while ($row = $result->fetch_assoc()) {
        $responsables[] = $row;
    }

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'data' => $responsables,
        'total_registros' => (int)$total_registros,
        'pagina_actual' => $pagina,
        'registros_por_pagina' => $registros_por_pagina,
        'total_paginas' => ceil($total_registros / $registros_por_pagina)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener responsables: ' . $e->getMessage()
    ]);
}

$conn->close();
?>