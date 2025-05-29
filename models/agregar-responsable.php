<?php
include 'conexion.php';

$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$id_cargo = $_POST['estado_id'];

$query = "INSERT INTO responsables (nombres, apellidos, id_cargo) VALUES ('$nombres', '$apellidos', $id_cargo)";
mysqli_query($conexion, $query);

// Redirige a donde tú necesites (ajusta el path si es necesario)
header('Location: ../vistas/responsables.php');
exit();
?>
