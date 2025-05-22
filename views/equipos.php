<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos</title>
    <link rel="stylesheet" href="../style/dash.css"> <!-- Estilos de navbar y sidebar -->
    <link rel="stylesheet" href="../style/equipos.css"> <!-- Estilos de filtros y tablas -->
    <link rel="stylesheet" href="../style/modal-filtro-equipo.css"> <!-- Estilo de modales  -->
    <link rel="stylesheet" href="../style/equipos-form.css"> <!-- Estilo de formulario  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">

  </head>

<body>
    <?php include_once '../include/navigation.php'; ?>

    <div class="contenedor"> <!-- Cuerpo contenedor de todo -->

        <div class="header"> <!-- Titulo de la pagina -->
          <h1 class="titulo">Equipos</h1>
        </div>

        <div class="filtros"> <!-- Cuerpo de los filtros -->
          <div class="flitro-contenedor-icono">
            <img class="filtro-icono" src="../img/filtro.png" alt="Filtro" width="28px" height="28px">
          </div>

          <div class="filtro-elementos">
            <p class="filtro-texto">Filtrar por:</p>

            <p class="filtro-texto">Fecha</p>
            <button id="f-fecha" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <p class="filtro-texto">Equipo</p>
            <button id="f-equipo" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>
            
            <p class="filtro-texto">Marca</p>
             <button id="f-marca" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <p class="filtro-texto">Estado</p>
             <button id="f-estado" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <img class="reiniciar-filtro" src="../img/reiniciar.png" alt="flecha">
            <p class="filtro-texto-rojo">Reiniciar filtro</p>

            <button class="btn-imprimir" id="btn-imprimir">Imprimir lista</button>
            <button class="btn-agregar" id="btn-agregar">Agregar equipo</button>
          </div>

        </div>

<?php
require_once '../models/equipos-controller.php'; // SOLUCIÓN: Usar la función que SÍ funciona

$equipos = obtenerEquiposAlternativa(); // Usar la función alternativa que crea su propia conexión

echo "<!-- DEBUG: Número de equipos encontrados: " . count($equipos) . " -->"; // DEBUG: Mostrar información para debugging
if (empty($equipos)) {
    echo "<!-- DEBUG: No se encontraron equipos. Verificar base de datos y tablas -->";
}
?>

  <main class="tabla-principal"> <!-- Cuerpo del contenedor de la tabla entera -->
    <div class="tabla-wrapper">

      <table class="tabla-header"> <!-- Encabezado de la tabla (sin cambios) -->
        <thead>
          <tr>
            <th class="th">ID</th>
            <th class="th">Equipo</th>
            <th class="th">Marca</th>
            <th class="th">Modelo</th>
            <th class="th">No. de serie</th>
            <th class="th">Estado</th>
            <th class="th">Acción</th>
          </tr>
        </thead>         
      </table>

    <div class="tabla-scroll"> <!-- Cuerpo de la tabla con datos dinámicos -->
      <table class="tabla-body">
        <tbody>
                
<?php 
  // Verificar si hay equipos para mostrar
  if (!empty($equipos))  {
  // Recorrer cada equipo y crear una fila
  foreach ($equipos as $equipo) {
  // Obtener la clase CSS para el estado
  $claseEstado = obtenerClaseEstado($equipo['estado']);
?>
      <tr class="tr">
        <td><?php echo htmlspecialchars($equipo['id']); ?></td>
        <td><?php echo htmlspecialchars($equipo['tipo_equipo']); ?></td>
        <td><?php echo htmlspecialchars($equipo['marca']); ?></td>
        <td><?php echo htmlspecialchars($equipo['modelo']); ?></td>
        <td><?php echo htmlspecialchars($equipo['numero_serie']); ?></td>
        
        <td class="Estado">
        <span class="<?php echo $claseEstado; ?>">
          <?php echo htmlspecialchars($equipo['estado']); ?>
        </span>
        </td>

        <td>
          <div class="btn-group">
              <button class="btn-izq" onclick="editarEquipo(<?php echo $equipo['id']; ?>)">
                <img src="../img/pincel.png" width="24px" height="25px" class="img">
              </button>

              <button class="btn-der" onclick="eliminarEquipo(<?php echo $equipo['id']; ?>)">
                <img src="../img/basura.png" width="23px" height="25px" class="img">
              </button>
          </div>
        </td>
      </tr>
<?php
  }
    } else {
      // Si no hay equipos, mostrar mensaje
        ?>
          <tr class="tr">
            <td colspan="7" style="text-align: center;">
              No hay equipos registrados o hay un problema con la base de datos
            </td>
          </tr>
  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

  </main>

          <?php include_once '../include/modal-filtro-equipo.php'; ?> <!-- cuerpo de modal-filtro-equipo -->
          <?php include_once '../include/modal-filtro-marca.php'; ?> <!-- cuerpo de modal-filtro-marca -->
          <?php include_once '../include/modal-filtro-estado.php'; ?> <!-- cuerpo de modal-filtro-estado -->
          <?php include_once '../include/equipos-form.php'; ?> <!-- cuerpo de equipos-form -->


    </div>

<script src="../js/equipos.js"></script>

</body>
</html>