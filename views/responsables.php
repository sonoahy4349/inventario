<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/dash.css">
    <link rel="stylesheet" href="../style/responsables.css">
    <link rel="stylesheet" href="../style/responsables-form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    
</head>
<body>
    <?php include_once '../include/navigation.php'; ?>

    <div class="contenedor">

        <div class="header">
          <h1 class="titulo">Responsables</h1>
          <button id="btn-agregar-usuario" class="btn-usuario">+ Añadir</button>
        </div>

   <?php
// Incluir la conexión a la base de datos
require_once '../models/conexion.php';

// Consultar responsables con sus cargos
$sql = "SELECT r.id_responsable, r.nombre, r.apellidos, c.nombre_cargo 
        FROM responsable r 
        INNER JOIN cargos c ON r.id_cargo = c.id_cargo 
        ORDER BY r.nombre, r.apellidos";

$result = $conn->query($sql);
?>

<main class="main">
    <?php
    if ($result && $result->num_rows > 0) {
        // Mostrar cada responsable
        while($row = $result->fetch_assoc()) {
            // Determinar la imagen según el género (puedes ajustar esta lógica)
            // Por ahora, alternamos entre hombre y mujer
            $imagen = (rand(0, 1) == 0) ? "../img/hombre.png" : "../img/mujer.png";
            
            echo '<div class="card">';
            echo '    <div class="card-avatar">';
            echo '        <img src="' . $imagen . '" alt="' . htmlspecialchars($row['nombre'] . ' ' . $row['apellidos']) . '" width="100" height="100">';
            echo '    </div>';
            echo '    <div class="card-body">';
            echo '        <p class="nombre">' . htmlspecialchars($row['nombre'] . ' ' . $row['apellidos']) . '</p>';
            echo '        <p class="cargo">' . htmlspecialchars($row['nombre_cargo']) . '</p>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        // Si no hay responsables, mostrar mensaje
        echo '<div style="text-align: center; padding: 50px; color: #666;">';
        echo '    <h3>No hay responsables registrados</h3>';
        echo '    <p>Agrega el primer responsable usando el formulario.</p>';
        echo '</div>';
    }
    
    // Cerrar conexión
    $conn->close();
    ?>
</main>
<?php include_once '../include/responsables-form.php'; ?>

    </div>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const btnAbrir = document.getElementById("btn-agregar-usuario");
    const btnCancelar = document.getElementById("btn-cancelar");
    const modal = document.querySelector(".container-form");

    btnAbrir.addEventListener("click", function () {
      modal.classList.remove("hidden");
    });

    btnCancelar.addEventListener("click", function () {
      modal.classList.add("hidden");
    });
  });
</script>

</body>
</html>