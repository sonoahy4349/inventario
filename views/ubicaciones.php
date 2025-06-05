<?php
// Incluir conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helpdesk";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Configuración de paginación
$filasPorPagina = 11; // Puedes cambiar este número
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$paginaActual = max(1, $paginaActual); // Asegurar que no sea menor a 1
$offset = ($paginaActual - 1) * $filasPorPagina;

// Contar total de ubicaciones
$sqlCount = "SELECT COUNT(*) as total FROM ubicaciones u
             JOIN edificios e ON u.edificio_id = e.id
             JOIN plantas p ON u.planta_id = p.id";
$resultCount = $conn->query($sqlCount);
$totalUbicaciones = $resultCount->fetch_assoc()['total'];
$totalPaginas = ceil($totalUbicaciones / $filasPorPagina);

// Consulta para obtener ubicaciones de la página actual
$sql = "SELECT 
            u.id,
            e.nombre AS edificio,
            CONCAT(p.nombre, ' (', p.numero_planta, ')') AS planta,
            COALESCE(s.nombre, 'Sin asignar') AS servicio,
            COALESCE(ui.nombre, 'Sin asignar') AS ubicacion_interna
        FROM ubicaciones u
        JOIN edificios e ON u.edificio_id = e.id
        JOIN plantas p ON u.planta_id = p.id
        LEFT JOIN servicios s ON u.servicio_id = s.id
        LEFT JOIN ubicaciones_internas ui ON u.ubicacion_interna_id = ui.id
        ORDER BY e.nombre, p.numero_planta
        LIMIT $offset, $filasPorPagina";

$result = $conn->query($sql);
$ubicacionesPagina = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ubicacionesPagina[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/dash.css">
    <link rel="stylesheet" href="../style/ubicaciones.css">
    <link rel="stylesheet" href="../style/ubicaciones-form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    
</head>
<body>
    <?php include_once '../include/navigation.php'; ?>

    <div class="contenedor">
        <div class="header">
          <h1 class="titulo">Ubicaciones</h1>
        </div>

        <div class="filtros">
          <div class="flitro-contenedor-icono">
            <img class="filtro-icono" src="../img/filtro.png" alt="Filtro" width="28px" height="28px">
          </div>

          <div class="filtro-elementos">
            <p class="filtro-texto">Filtrar por:</p>

            <p class="filtro-texto">Edificio</p>
            <button id="f-fecha" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <p class="filtro-texto">Planta</p>
            <button id="f-equipo" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <p class="filtro-texto">Servicio</p>
             <button id="f-ubicacion" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <p class="filtro-texto">Ubicacion interna</p>
             <button id="f-estado" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <img class="reiniciar-filtro" src="../img/reiniciar.png" alt="flecha">

            <button class="btn-imprimir" id="btn-imprimir">Imprimir lista</button>
            <button class="btn-agregar" id="btn-agregar-ubicacion">Nueva Ubicacion</button>
          </div>

        </div>

    <main class="tabla-principal">
        <div class="tabla-wrapper">
            <table class="tabla-header">
                <thead>
                    <tr>
                        <th class="th">ID</th>
                        <th class="th">Edificio</th>
                        <th class="th">Planta</th>
                        <th class="th">Servicio</th>
                        <th class="th">Ubicación interna</th>
                        <th class="th">Acción</th>
                    </tr>
                </thead>
            </table>

            <div class="tabla-scroll">
                <table class="tabla-body">
                    <tbody>
                        <?php
                        if (!empty($ubicacionesPagina)) {
                            // Recorrer cada ubicación de la página actual
                            foreach ($ubicacionesPagina as $ubicacion) {
                        ?>
                                <tr class="tr" id="fila-ubicacion-<?php echo $ubicacion['id']; ?>">
                                    <td><?php echo htmlspecialchars($ubicacion['id']); ?></td>
                                    <td><?php echo htmlspecialchars($ubicacion['edificio']); ?></td>
                                    <td><?php echo htmlspecialchars($ubicacion['planta']); ?></td>
                                    <td><?php echo htmlspecialchars($ubicacion['servicio']); ?></td>
                                    <td><?php echo htmlspecialchars($ubicacion['ubicacion_interna']); ?></td>
                                    <td>
                                        <div class="btn-group" id="ubicacion-<?php echo $ubicacion['id']; ?>">
                                            <button class="btn-izq" onclick="editarUbicacion(<?php echo $ubicacion['id']; ?>)">
                                                <img src="../img/pincel.png" width="24px" height="25px" class="img">
                                            </button>
                                            <button class="btn-der" onclick="eliminarUbicacion(<?php echo $ubicacion['id']; ?>)">
                                                <img src="../img/basura.png" width="23px" height="25px" class="img">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            // Si no hay ubicaciones, mostrar mensaje
                        ?>
                            <tr class="tr">
                                <td colspan="6" class="tabla-vacia">
                                    <?php if ($totalUbicaciones == 0): ?>
                                        No hay ubicaciones registradas o hay un problema con la base de datos
                                    <?php else: ?>
                                        No hay ubicaciones para mostrar en esta página
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
                    if ($totalUbicaciones > 0) {
                        $inicio = $offset + 1;
                        $fin = min($offset + $filasPorPagina, $totalUbicaciones);
                        echo "Mostrando $inicio-$fin de $totalUbicaciones ubicaciones";
                    } else {
                        echo "No hay ubicaciones para mostrar";
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
         <?php include_once '../include/ubicaciones-form.php'; ?>
      </main>
    </div>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const btnAbrir = document.getElementById("btn-agregar-ubicacion");
    const btnCancelar = document.getElementById("btn-cancelar-ubicacion");
    const modal = document.querySelector(".container-form");

    btnAbrir.addEventListener("click", function () {
      modal.classList.remove("hidden");
    });

    btnCancelar.addEventListener("click", function () {
      modal.classList.add("hidden");
    });
  });
</script>

<script>
  function eliminarUbicacion(id) {
    if (confirm("¿Estás seguro de que deseas eliminar esta ubicación?")) {
      fetch("../models/ubicaciones-controller.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "action=eliminar&id=" + encodeURIComponent(id)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload(); // recarga la página al éxito
        } else {
          alert("Error: " + (data.message || "No se pudo eliminar"));
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("Error al procesar la solicitud");
      });
    }
  }
</script>


 
</body>
</html>