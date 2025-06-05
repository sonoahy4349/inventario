<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estaciones</title>
    <link rel="stylesheet" href="../style/dash.css"> <!-- Estilos de navbar y sidebar -->
    <link rel="stylesheet" href="../style/estaciones.css"> <!-- Estilos de filtros y tablas -->
    <link rel="stylesheet" href="../style/estaciones-form.css"> <!-- Estilo de modales  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../include/navigation.php'; ?> <!-- Incluye la barra de navegacion y sidebar -->

    <div class="contenedor"> <!-- Cuerpo contenedor de todo -->

        <div class="header"> <!-- Titulo de la pagina -->
            <h1 class="titulo">Estaciones</h1>
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
                <button class="btn-agregar" id="btn-editar">Editar estación</button>
                <button class="btn-agregar" id="btn-agregar">Agregar estación</button>
            </div>
        </div>

        <main class="tabla-principal"> <!-- Cuerpo del contenedor de la tabla entera -->
            <div class="tabla-wrapper">

                <table class="tabla-header"> <!-- Encabezado de la tabla -->
                    <thead>
                        <tr>
                            <th class="th small">No.</th>
                            <th class="th">Equipo Principal</th>
                            <th class="th">Marca</th>
                            <th class="th">Modelo</th>
                            <th class="th">No. de serie</th>
                            <th class="th">Equipo Secundario</th>
                            <th class="th">Marca</th>
                            <th class="th">Modelo</th>
                            <th class="th">No. de serie</th>
                            <th class="th">Edificio</th>
                            <th class="th">Planta</th>
                            <th class="th">Servicio</th>
                            <th class="th">Ubicación interna</th>
                            <th class="th">Responsable</th>
                        </tr>
                    </thead>         
                </table>

                <div class="tabla-scroll"> <!-- Cuerpo de la tabla con datos dinámicos -->
                    <table class="tabla-body">
                        <tbody>
                            <?php
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

                            // Query para obtener todas las estaciones con sus relaciones
                            $sql = "SELECT 
                                        e.id as estacion_id,
                                        -- Equipo principal
                                        ep.id as equipo_principal_id,
                                        etp.nombre as equipo_principal_tipo,
                                        emp.nombre as equipo_principal_marca,
                                        ep.modelo as equipo_principal_modelo,
                                        ep.numero_serie as equipo_principal_serie,
                                        -- Equipo secundario (opcional)
                                        es.id as equipo_secundario_id,
                                        ets.nombre as equipo_secundario_tipo,
                                        ems.nombre as equipo_secundario_marca,
                                        es.modelo as equipo_secundario_modelo,
                                        es.numero_serie as equipo_secundario_serie,
                                        -- Ubicación
                                        ed.nombre as edificio_nombre,
                                        p.nombre as planta_nombre,
                                        s.nombre as servicio_nombre,
                                        ui.nombre as ubicacion_interna_nombre,
                                        -- Responsable
                                        CONCAT(r.nombre, ' ', r.apellidos) as responsable_nombre
                                    FROM estaciones e
                                    -- Equipo principal (obligatorio)
                                    LEFT JOIN equipos ep ON e.equipo_principal_id = ep.id
                                    LEFT JOIN equipo_tipo etp ON ep.tipo_id = etp.id
                                    LEFT JOIN equipo_marca emp ON ep.marca_id = emp.id
                                    -- Equipo secundario (opcional)
                                    LEFT JOIN equipos es ON e.equipo_secundario_id = es.id
                                    LEFT JOIN equipo_tipo ets ON es.tipo_id = ets.id
                                    LEFT JOIN equipo_marca ems ON es.marca_id = ems.id
                                    -- Ubicación
                                    LEFT JOIN ubicaciones u ON e.ubicacion_id = u.id
                                    LEFT JOIN edificios ed ON u.edificio_id = ed.id
                                    LEFT JOIN plantas p ON u.planta_id = p.id
                                    LEFT JOIN servicios s ON u.servicio_id = s.id
                                    LEFT JOIN ubicaciones_internas ui ON u.ubicacion_interna_id = ui.id
                                    -- Responsable
                                    LEFT JOIN responsable r ON e.responsable_id = r.id_responsable
                                    WHERE e.activo = 1
                                    ORDER BY e.id";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $contador = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr class='tr small fila-ajustada' id='fila-equipo-".$row['estacion_id']."'>";
                                    echo "<td>".$contador."</td>";
                                    
                                    // Equipo principal
                                    echo "<td>".($row['equipo_principal_tipo'] ?? 'N/A')."</td>";
                                    echo "<td>".($row['equipo_principal_marca'] ?? 'N/A')."</td>";
                                    echo "<td>".($row['equipo_principal_modelo'] ?? 'N/A')."</td>";
                                    echo "<td>".($row['equipo_principal_serie'] ?? 'N/A')."</td>";
                                    
                                    // Equipo secundario (puede ser vacío)
                                    echo "<td>".($row['equipo_secundario_tipo'] ?? '-')."</td>";
                                    echo "<td>".($row['equipo_secundario_marca'] ?? '-')."</td>";
                                    echo "<td>".($row['equipo_secundario_modelo'] ?? '-')."</td>";
                                    echo "<td>".($row['equipo_secundario_serie'] ?? '-')."</td>";
                                    
                                    // Ubicación
                                    echo "<td>".($row['edificio_nombre'] ?? 'N/A')."</td>";
                                    echo "<td>".($row['planta_nombre'] ?? 'N/A')."</td>";
                                    echo "<td>".($row['servicio_nombre'] ?? 'N/A')."</td>";
                                    echo "<td>".($row['ubicacion_interna_nombre'] ?? 'N/A')."</td>";
                                    
                                    // Responsable
                                    echo "<td>".($row['responsable_nombre'] ?? 'N/A')."</td>";
                                    
                                    echo "</tr>";
                                    $contador++;
                                }
                            } else {
                                echo "<tr><td colspan='14'>No hay estaciones registradas</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
                
        </main>
        <?php include '../include/estaciones-form.php'; ?> <!-- Incluye el footer de la pagina -->
    </div>

   <script>
  // modal (form)
  document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('container-form');
  const openFormButton = document.getElementById('btn-agregar');
  const closeFormButton = document.getElementById('btn-cancelar');

  openFormButton.addEventListener('click', () => {
    form.classList.remove('hidden');
  });

  closeFormButton.addEventListener('click', () => {
    form.classList.add('hidden');
  });
});
</script>
</body>
</html>