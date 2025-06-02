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
<script src="../js/equipos.js"></script>

<body>
   

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
require_once '../models/equipos-controller.php';
?>

  <main class="tabla-principal"> <!-- Cuerpo del contenedor de la tabla entera -->
    <div class="tabla-wrapper">

      <table class="tabla-header"> <!-- Encabezado de la tabla -->
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
if (!empty($equiposPagina)) {
    // Recorrer cada equipo de la página actual
    foreach ($equiposPagina as $equipo) {
        // Obtener la clase CSS para el estado
        $claseEstado = obtenerClaseEstado($equipo['estado']);
?>
      <tr class="tr" id="fila-equipo-<?php echo $equipo['id']; ?>">
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
          <div class="btn-group" id="equipo-<?php echo $equipo['id']; ?>">
              <button class="btn-izq" onclick="editarEquipo(<?php echo $equipo['id']; ?>)"> <!-- boton para editar equipo -->
                  <img src="../img/pincel.png" width="24px" height="25px" class="img">
              </button>

              <button class="btn-der" onclick="eliminarEquipo(<?php echo $equipo['id']; ?>)"> <!-- boton para eliminar equipo -->
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
            <td colspan="7" class="tabla-vacia">
              <?php if ($totalEquipos == 0): ?>
                No hay equipos registrados o hay un problema con la base de datos
              <?php else: ?>
                No hay equipos para mostrar en esta página
              <?php endif; ?>
            </td>
          </tr>
<?php } ?>
              </tbody>
            </table>
          </div>
          
          <!-- Contenedor de paginación -->
          <?php if ($totalPaginas > 1): ?>
          <div class="paginacion-container">
            <div class="paginacion-info">
              <?php 
              if ($totalEquipos > 0) {
                  $inicio = $offset + 1;
                  $fin = min($offset + $filasPorPagina, $totalEquipos);
                  echo "Mostrando $inicio-$fin de $totalEquipos equipos";
              } else {
                  echo "No hay equipos para mostrar";
              }
              ?>
            </div>
            
            <div class="paginacion-controles">
              <?php
              // Función para construir URL con parámetros
              function construirUrl($pagina) {
                  $params = $_GET;
                  $params['pagina'] = $pagina;
                  return '?' . http_build_query($params);
              }
              
              // Botón Anterior
              if ($paginaActual > 1): ?>
                <a href="<?php echo construirUrl($paginaActual - 1); ?>" class="paginacion-btn">‹ Anterior</a>
              <?php else: ?>
                <span class="paginacion-btn deshabilitado">‹ Anterior</span>
              <?php endif;
              
              // Lógica para mostrar números de página
              $maxBotones = 5;
              $inicio = max(1, $paginaActual - floor($maxBotones / 2));
              $fin = min($totalPaginas, $inicio + $maxBotones - 1);
              
              // Ajustar el inicio si no hay suficientes páginas al final
              if ($fin - $inicio < $maxBotones - 1) {
                  $inicio = max(1, $fin - $maxBotones + 1);
              }
              
              // Primera página y puntos suspensivos
              if ($inicio > 1) {
                  echo '<a href="' . construirUrl(1) . '" class="paginacion-btn">1</a>';
                  if ($inicio > 2) {
                      echo '<span class="paginacion-puntos">...</span>';
                  }
              }
              
              // Páginas numeradas
              for ($i = $inicio; $i <= $fin; $i++) {
                  if ($i == $paginaActual) {
                      echo '<span class="paginacion-btn activo">' . $i . '</span>';
                  } else {
                      echo '<a href="' . construirUrl($i) . '" class="paginacion-btn">' . $i . '</a>';
                  }
              }
              
              // Última página y puntos suspensivos
              if ($fin < $totalPaginas) {
                  if ($fin < $totalPaginas - 1) {
                      echo '<span class="paginacion-puntos">...</span>';
                  }
                  echo '<a href="' . construirUrl($totalPaginas) . '" class="paginacion-btn">' . $totalPaginas . '</a>';
              }
              
              // Botón Siguiente
              if ($paginaActual < $totalPaginas): ?>
                <a href="<?php echo construirUrl($paginaActual + 1); ?>" class="paginacion-btn">Siguiente ›</a>
              <?php else: ?>
                <span class="paginacion-btn deshabilitado">Siguiente ›</span>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>
          
        </div>
  </main>

          <?php include_once '../include/modales-equipo.php'; ?>
          <?php include_once '../include/equipos-form.php'; ?>

    </div>

 <?php include_once '../include/navigation.php'; ?>

</body>
</html>