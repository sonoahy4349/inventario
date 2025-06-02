<?php
session_start();
require_once '../models/conexion.php';

// =========================
// Funciones reutilizables
// =========================

function obtenerEquipos($conn) {
    $sql = "SELECT 
                e.id,
                et.nombre as tipo_equipo,
                em.nombre as marca,
                e.modelo,
                e.numero_serie,
                es.nombre as estado
            FROM equipos e
            INNER JOIN equipo_tipo et ON e.tipo_id = et.id
            INNER JOIN equipo_marca em ON e.marca_id = em.id  
            INNER JOIN estados_equipo es ON e.estado_id = es.id
            ORDER BY e.id";
    
    $resultado = $conn->query($sql);
    $equipos = [];

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $equipos[] = $fila;
        }
    }

    return $equipos;
}

function obtenerClaseEstado($estado) {
    switch(strtolower($estado)) {
        case 'disponible': return 'disponible';
        case 'en uso': return 'en-uso';
        case 'mantenimiento': return 'mantenimiento';
        case 'dado de baja': return 'baja';
        case 'en préstamo': return 'prestamo';
        default: return 'disponible';
    }
}

// =========================
// Lógica de acciones
// =========================

$accion = $_GET['accion'] ?? $_POST['accion'] ?? null;

// ---- AGREGAR EQUIPO ----
if ($accion === 'agregar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_id = $_POST["tipo_id"];
    $marca_id = $_POST["marca_id"];
    $modelo = $_POST["modelo"];
    $numero_serie = $_POST["numero_serie"];
    $estado_id = $_POST["estado_id"];

    if (empty($tipo_id) || empty($marca_id) || empty($modelo) || empty($numero_serie) || empty($estado_id)) {
        die("Todos los campos son obligatorios.");
    }

    $stmt = $conn->prepare("INSERT INTO equipos (tipo_id, marca_id, modelo, numero_serie, estado_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissi", $tipo_id, $marca_id, $modelo, $numero_serie, $estado_id);

    if ($stmt->execute()) {
        header("Location: ../views/equipos.php?success=1");
        exit();
    } else {
        echo "Error al agregar equipo: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: ../views/equipos.php?success=1");
exit();
}

// ---- ELIMINAR EQUIPO ----
if ($accion === 'eliminar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    $conn->query("DELETE FROM ticket_equipos WHERE equipo_id = $id");

    $sql = "DELETE FROM equipos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
    exit();
}

// ---- OBTENER LISTA DE EQUIPOS (por defecto) ----
$equipos = obtenerEquipos($conn);

// PAGINACIÓN
$filasPorPagina = 11;
$paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

$totalEquipos = count($equipos);
$totalPaginas = ceil($totalEquipos / $filasPorPagina);
$paginaActual = min($paginaActual, $totalPaginas);

$offset = ($paginaActual - 1) * $filasPorPagina;
$equiposPagina = array_slice($equipos, $offset, $filasPorPagina);

echo "<!-- DEBUG: Total equipos: $totalEquipos, Página: $paginaActual/$totalPaginas -->";
?>
