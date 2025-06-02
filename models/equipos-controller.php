<?php
// Archivo: obtener_equipos.php
// Este archivo obtiene todos los equipos de la base de datos usando MySQLi

// SOLUCIÓN 1: Incluir conexión y verificar que existe
require_once '../models/conexion.php';

function obtenerEquipos() {
    global $conexion;
    
    // VERIFICAR que la conexión existe
    if (!$conexion) {
        echo "Error: No hay conexión a la base de datos";
        return [];
    }
    
    // SQL para obtener los equipos con sus relaciones (JOIN)
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
    
    // Ejecutar la consulta
    $resultado = $conexion->query($sql);
    
    // Verificar si la consulta fue exitosa
    if ($resultado) {
        // Crear un array para almacenar los equipos
        $equipos = [];
        
        // Obtener cada fila como un array asociativo
        while ($fila = $resultado->fetch_assoc()) {
            $equipos[] = $fila;
        }
        
        return $equipos;
    } else {
        // Si hay error, mostrar mensaje
        echo "Error en la consulta: " . $conexion->error;
        return [];
    }
}

// SOLUCIÓN 2: Función alternativa que crea su propia conexión
function obtenerEquiposAlternativa() {
    // Crear conexión dentro de la función
    $host = "localhost";
    $usuario = "root";
    $contrasena = "";
    $base_de_datos = "helpdesk"; // Cambia por "helpdesk" si es necesario
    
    $conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);
    $conn->set_charset("utf8");
    
    if ($conn->connect_error) {
        echo "Error de conexión: " . $conn->connect_error;
        return [];
    }
    
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
    
    $conn->close();
    return $equipos;
}

// Función para obtener la clase CSS según el estado
function obtenerClaseEstado($estado) {
    switch(strtolower($estado)) {
        case 'disponible':
            return 'disponible';
        case 'en uso':
            return 'en-uso';
        case 'mantenimiento':
            return 'mantenimiento';
        case 'dado de baja':
            return 'baja';
        case 'en préstamo':
            return 'prestamo';
        default:
            return 'disponible';
    }
}

// Configuración de paginación
$filasPorPagina = 11;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$paginaActual = max(1, $paginaActual); // Asegurar que sea mínimo 1

// Obtener todos los equipos
$equipos = obtenerEquiposAlternativa();
$totalEquipos = count($equipos);
$totalPaginas = ceil($totalEquipos / $filasPorPagina);

// Asegurar que la página actual no exceda el total
$paginaActual = min($paginaActual, max(1, $totalPaginas));

// Calcular el offset para la consulta
$offset = ($paginaActual - 1) * $filasPorPagina;

// Obtener equipos para la página actual
$equiposPagina = array_slice($equipos, $offset, $filasPorPagina);

echo "<!-- DEBUG: Total equipos: $totalEquipos, Página: $paginaActual/$totalPaginas -->";

?>
