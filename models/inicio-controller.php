
<?php
// inicio_controller.php - Contiene toda la lógica PHP

// Incluir archivo de conexión a la base de datos
include('conexion.php');

// Consultar el total de equipos
$sqlTotal = "SELECT COUNT(*) as total FROM equipos";
$resultTotal = $conn->query($sqlTotal);
$rowTotal = $resultTotal->fetch_assoc();
$totalEquipos = $rowTotal['total'];

// Obtener IDs de estados
$sqlIdEnUso = "SELECT id FROM estados_equipo WHERE nombre = 'En uso'";
$resultIdEnUso = $conn->query($sqlIdEnUso);
$idEnUso = ($resultIdEnUso->num_rows > 0) ? $resultIdEnUso->fetch_assoc()['id'] : 0;

$sqlIdDisponible = "SELECT id FROM estados_equipo WHERE nombre = 'Disponible'";
$resultIdDisponible = $conn->query($sqlIdDisponible);
$idDisponible = ($resultIdDisponible->num_rows > 0) ? $resultIdDisponible->fetch_assoc()['id'] : 0;

$sqlIdMantenimiento = "SELECT id FROM estados_equipo WHERE nombre = 'En mantenimiento'";
$resultIdMantenimiento = $conn->query($sqlIdMantenimiento);
$idMantenimiento = ($resultIdMantenimiento->num_rows > 0) ? $resultIdMantenimiento->fetch_assoc()['id'] : 0;

// Consultar equipos en uso
$sqlEnUso = "SELECT COUNT(*) as total FROM equipos WHERE estado_id = $idEnUso";
$resultEnUso = $conn->query($sqlEnUso);
$rowEnUso = $resultEnUso->fetch_assoc();
$equiposEnUso = $rowEnUso['total'];

// Consultar equipos disponibles
$sqlDisponible = "SELECT COUNT(*) as total FROM equipos WHERE estado_id = $idDisponible";
$resultDisponible = $conn->query($sqlDisponible);
$rowDisponible = $resultDisponible->fetch_assoc();
$equiposDisponibles = $rowDisponible['total'];

// Consultar equipos en mantenimiento
$sqlMantenimiento = "SELECT COUNT(*) as total FROM equipos WHERE estado_id = $idMantenimiento";
$resultMantenimiento = $conn->query($sqlMantenimiento);
$rowMantenimiento = $resultMantenimiento->fetch_assoc();
$equiposEnMantenimiento = $rowMantenimiento['total'];


$sql_total = "SELECT COUNT(*) as total FROM ubicaciones";
$sql_edificios = "SELECT COUNT(DISTINCT edificio) as total FROM ubicaciones";
$sql_servicios = "SELECT COUNT(DISTINCT servicio) as total FROM ubicaciones WHERE servicio IS NOT NULL";
$sql_ubicaciones = "SELECT COUNT(DISTINCT ubicacion_interna) as total FROM ubicaciones WHERE ubicacion_interna IS NOT NULL";

// Ejecutar consultas
$resultado_total = $conn->query($sql_total);
$resultado_edificios = $conn->query($sql_edificios);
$resultado_servicios = $conn->query($sql_servicios);
$resultado_ubicaciones = $conn->query($sql_ubicaciones);

// Obtener los resultados
$total = ($resultado_total && $resultado_total->num_rows > 0) ? $resultado_total->fetch_assoc()['total'] : 0;
$edificios = ($resultado_edificios && $resultado_edificios->num_rows > 0) ? $resultado_edificios->fetch_assoc()['total'] : 0;
$servicios = ($resultado_servicios && $resultado_servicios->num_rows > 0) ? $resultado_servicios->fetch_assoc()['total'] : 0;
$ubicaciones_internas = ($resultado_ubicaciones && $resultado_ubicaciones->num_rows > 0) ? $resultado_ubicaciones->fetch_assoc()['total'] : 0;

?>