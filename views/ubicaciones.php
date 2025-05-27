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

// Consulta para obtener todas las ubicaciones con sus datos relacionados
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
        ORDER BY e.nombre, p.numero_planta";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/dash.css">
    <link rel="stylesheet" href="../style/ubicaciones.css">
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
              <!-- The Modal -->
              <div id="m-equipo" class="m-equipo">

                <!-- Modal content -->
                <div class="modal-content">
                  <span class="close">&times;</span>
                  <p>Some text in the Modal..</p>
                </div>

              </div>

            <p class="filtro-texto">Servicio</p>
             <button id="f-ubicacion" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <p class="filtro-texto">Ubicacion interna</p>
             <button id="f-estado" class="filtro-boton"><img src="../img/flecha-abajo.png" alt="flecha"></button>

            <img class="reiniciar-filtro" src="../img/reiniciar.png" alt="flecha">
          </div>

        </div>

 <main class="tabla-principal">
        <div class="tabla-wrapper">
            <table class="tabla-header">
                <thead>
                    <tr>
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
                        if ($result->num_rows > 0) {
                            // Mostrar datos de cada fila
                            while($row = $result->fetch_assoc()) {
                                echo "<tr class='tr'>";
                                echo "<td>" . htmlspecialchars($row["edificio"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["planta"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["servicio"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["ubicacion_interna"]) . "</td>";
                                echo "<td>";
                                echo "<div class='btn-group'>";
                                echo "<button class='btn-izq' onclick='editarUbicacion(" . $row["id"] . ")'>";
                                echo "<img src='../img/pincel.png' width='24px' height='25px' class='img'>";
                                echo "</button>";
                                echo "<button class='btn-der' onclick='eliminarUbicacion(" . $row["id"] . ")'>";
                                echo "<img src='../img/basura.png' width='23px' height='25px' class='img'>";
                                echo "</button>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr class='tr'>";
                            echo "<td colspan='5' style='text-align: center; padding: 20px;'>No hay ubicaciones registradas</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    </div>

 
</body>
</html>