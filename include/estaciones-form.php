<?php include '../models/conexion.php'; ?>

<div id="container-form" class="container-form hidden">
  <div class="form-box">
    <h1 class="h1-form">Agregar nueva estación</h1>
    <form class="form-estaciones" action="../models/estaciones-controller.php" method="POST">
    <input type="hidden" name="accion" value="agregar">
    
      <div class="divisor">
      <!-- Equipo Principal -->
      <div class="form-group">
        <label for="equipo_principal_id" class="nombre">Equipo Principal</label>
        <select id="equipo_principal_id" name="equipo_principal_id" required>
          <option value="" disabled selected>Selecciona el equipo principal</option>
          <?php
          $sql = "SELECT e.id, CONCAT('ID: ', e.id, ' - ', et.nombre, ' ', em.nombre, ' ', e.modelo) as equipo_info 
                  FROM equipos e 
                  LEFT JOIN equipo_tipo et ON e.tipo_id = et.id 
                  LEFT JOIN equipo_marca em ON e.marca_id = em.id 
                  WHERE e.id NOT IN (SELECT equipo_principal_id FROM estaciones WHERE activo = 1)
                  AND e.id NOT IN (SELECT equipo_secundario_id FROM estaciones WHERE equipo_secundario_id IS NOT NULL AND activo = 1)
                  ORDER BY e.id";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row["id"] . "'>" . $row["equipo_info"] . "</option>";
          }
          ?>
        </select>
      </div>

      <!-- Información del Equipo Principal (campos auto-rellenados) -->
      <div class="form-group">
        <label class="nombre">Equipo Principal</label>
        <input type="text" id="tipo_principal" class="input" readonly>
      </div>

      <div class="form-group">
        <label class="nombre">Marca</label>
        <input type="text" id="marca_principal" class="input" readonly>
      </div>

      <div class="form-group">
        <label class="nombre">Modelo</label>
        <input type="text" id="modelo_principal" class="input" readonly>
      </div>

      <div class="form-group">
        <label class="nombre">No. de Serie</label>
        <input type="text" id="serie_principal" class="input" readonly>
      </div>

      

     
      <!-- Equipo Secundario (Opcional) -->
      <div class="form-group">
        <label for="equipo_secundario_id" class="nombre">Equipo Secundario</label>
        <select id="equipo_secundario_id" name="equipo_secundario_id">
          <option value="" selected>Sin equipo secundario</option>
          <?php
          $sql = "SELECT e.id, CONCAT('ID: ', e.id, ' - ', et.nombre, ' ', em.nombre, ' ', e.modelo) as equipo_info 
                  FROM equipos e 
                  LEFT JOIN equipo_tipo et ON e.tipo_id = et.id 
                  LEFT JOIN equipo_marca em ON e.marca_id = em.id 
                  WHERE e.id NOT IN (SELECT equipo_principal_id FROM estaciones WHERE activo = 1)
                  AND e.id NOT IN (SELECT equipo_secundario_id FROM estaciones WHERE equipo_secundario_id IS NOT NULL AND activo = 1)
                  ORDER BY e.id";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row["id"] . "'>" . $row["equipo_info"] . "</option>";
          }
          ?>
        </select>
      </div>

      <!-- Información del Equipo Secundario (campos auto-rellenados) -->
      <div id="info-secundario" class="hidden">
        <div class="form-group">
          <label class="nombre">Equipo Secundario</label>
          <input type="text" id="tipo_secundario" class="input" readonly>
        </div>

        <div class="form-group">
          <label class="nombre">Marca</label>
          <input type="text" id="marca_secundario" class="input" readonly>
        </div>

        <div class="form-group">
          <label class="nombre">Modelo</label>
          <input type="text" id="modelo_secundario" class="input" readonly>
        </div>

        <div class="form-group">
          <label class="nombre">No. de Serie</label>
          <input type="text" id="serie_secundario" class="input" readonly>
        </div>
      </div>
      </div> <!-- Fin del divisor para Equipo Secundario -->



      <div class="divisor2">

      <!-- Fin del divisor para Equipo Secundario -->
      <ul class="filter-list">
        <li class="filter-element">
          <input type="checkbox" class="checkbox" id="checkbox1">
          <label for="checkbox1" class="checkbox-label">Teclado</label>
        </li>
        <li class="filter-element">
          <input type="checkbox" class="checkbox" id="checkbox2">
          <label for="checkbox2" class="checkbox-label">Mouse</label>
        </li>
        <li class="filter-element">
          <input type="checkbox" class="checkbox" id="checkbox3">
          <label for="checkbox3" class="checkbox-label">Cable de red</label>
        </li>
        <li class="filter-element">
          <input type="checkbox" class="checkbox" id="checkbox4">
          <label for="checkbox4" class="checkbox-label">Office</label>
        </li>
      </ul>
      
      <!-- Ubicación Interna -->
      <div class="form-group">
        <label for="ubicacion_id" class="nombre">Ubicación Interna</label>
        <select id="ubicacion_id" name="ubicacion_id" required>
          <option value="" disabled selected>Selecciona una ubicación</option>
          <?php
          $sql = "SELECT u.id, 
                         CONCAT(ui.nombre, ' - ', ed.nombre, ' ', p.nombre, 
                                CASE WHEN s.nombre IS NOT NULL THEN CONCAT(' (', s.nombre, ')') ELSE '' END) as ubicacion_info
                  FROM ubicaciones u
                  LEFT JOIN ubicaciones_internas ui ON u.ubicacion_interna_id = ui.id
                  LEFT JOIN edificios ed ON u.edificio_id = ed.id
                  LEFT JOIN plantas p ON u.planta_id = p.id
                  LEFT JOIN servicios s ON u.servicio_id = s.id
                  ORDER BY ed.nombre, p.numero_planta, ui.nombre";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row["id"] . "'>" . $row["ubicacion_info"] . "</option>";
          }
          ?>
        </select>
      </div>



      <!-- Información de Ubicación (campos auto-rellenados) -->
      <div class="form-group">
        <label class="nombre">Edificio</label>
        <input type="text" id="edificio_info" class="input" readonly>
      </div>

      <div class="form-group">
        <label class="nombre">Planta</label>
        <input type="text" id="planta_info" class="input" readonly>
      </div>

      <div class="form-group">
        <label class="nombre">Servicio</label>
        <input type="text" id="servicio_info" class="input" readonly>
      </div>

      <!-- Responsable -->
      <div class="form-group">
        <label for="responsable_id" class="nombre">Responsable</label>
        <select id="responsable_id" name="responsable_id" required>
          <option value="" disabled selected>Selecciona un responsable</option>
          <?php
          $sql = "SELECT r.id_responsable, CONCAT(r.nombre, ' ', r.apellidos, ' (', c.nombre_cargo, ')') as responsable_info
                  FROM responsable r
                  LEFT JOIN cargos c ON r.id_cargo = c.id_cargo
                  ORDER BY r.nombre, r.apellidos";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row["id_responsable"] . "'>" . $row["responsable_info"] . "</option>";
          }
          ?>
        </select>
      </div>

      <!-- Información del Responsable (campos auto-rellenados) -->
      <div class="form-group">
        <label class="nombre">Cargo del Responsable</label>
        <input type="text" id="cargo_responsable" class="input" readonly>
      </div>



      <div class="btn-group-form">
        <button type="button" id="btn-cancelar" class="btn-cancelar">Cancelar</button>
        <button type="submit" class="btn-agregar-form">Agregar</button>
      </div>
      </div> <!-- Fin del divisor para Responsable -->

    </form>
  </div>
</div>

<script>
// JavaScript para auto-rellenar campos cuando se selecciona un equipo principal
document.getElementById('equipo_principal_id').addEventListener('change', function() {
    var equipoId = this.value;
    if (equipoId) {
        fetch('../models/get-equipo-info.php?id=' + equipoId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('tipo_principal').value = data.tipo || '';
                document.getElementById('marca_principal').value = data.marca || '';
                document.getElementById('modelo_principal').value = data.modelo || '';
                document.getElementById('serie_principal').value = data.numero_serie || '';
                
                // Actualizar opciones del equipo secundario para excluir el seleccionado
                actualizarOpcionesSecundario(equipoId);
            })
            .catch(error => console.error('Error:', error));
    } else {
        limpiarCamposEquipo('principal');
    }
});

// JavaScript para auto-rellenar campos cuando se selecciona un equipo secundario
document.getElementById('equipo_secundario_id').addEventListener('change', function() {
    var equipoId = this.value;
    var infoSecundario = document.getElementById('info-secundario');
    
    if (equipoId) {
        fetch('../models/get-equipo-info.php?id=' + equipoId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('tipo_secundario').value = data.tipo || '';
                document.getElementById('marca_secundario').value = data.marca || '';
                document.getElementById('modelo_secundario').value = data.modelo || '';
                document.getElementById('serie_secundario').value = data.numero_serie || '';
                
                infoSecundario.classList.remove('hidden');
            })
            .catch(error => console.error('Error:', error));
    } else {
        limpiarCamposEquipo('secundario');
        infoSecundario.classList.add('hidden');
    }
});

// JavaScript para auto-rellenar campos cuando se selecciona una ubicación
document.getElementById('ubicacion_id').addEventListener('change', function() {
    var ubicacionId = this.value;
    if (ubicacionId) {
        fetch('../models/get-ubicacion-info.php?id=' + ubicacionId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edificio_info').value = data.edificio || '';
                document.getElementById('planta_info').value = data.planta || '';
                document.getElementById('servicio_info').value = data.servicio || '';
            })
            .catch(error => console.error('Error:', error));
    } else {
        limpiarCamposUbicacion();
    }
});

// JavaScript para auto-rellenar campos cuando se selecciona un responsable
document.getElementById('responsable_id').addEventListener('change', function() {
    var responsableId = this.value;
    if (responsableId) {
        fetch('../models/get-responsable-info.php?id=' + responsableId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('cargo_responsable').value = data.cargo || '';
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('cargo_responsable').value = '';
    }
});

// Función para limpiar campos de equipo
function limpiarCamposEquipo(tipo) {
    document.getElementById('tipo_' + tipo).value = '';
    document.getElementById('marca_' + tipo).value = '';
    document.getElementById('modelo_' + tipo).value = '';
    document.getElementById('serie_' + tipo).value = '';
}

// Función para limpiar campos de ubicación
function limpiarCamposUbicacion() {
    document.getElementById('edificio_info').value = '';
    document.getElementById('planta_info').value = '';
    document.getElementById('servicio_info').value = '';
}

// Función para actualizar opciones del equipo secundario
function actualizarOpcionesSecundario(equipoPrincipalId) {
    var selectSecundario = document.getElementById('equipo_secundario_id');
    var options = selectSecundario.options;
    
    for (var i = 0; i < options.length; i++) {
        if (options[i].value === equipoPrincipalId) {
            options[i].disabled = true;
            options[i].style.display = 'none';
        } else {
            options[i].disabled = false;
            options[i].style.display = 'block';
        }
    }
    
    // Si el equipo secundario seleccionado es el mismo que el principal, limpiarlo
    if (selectSecundario.value === equipoPrincipalId) {
        selectSecundario.value = '';
        limpiarCamposEquipo('secundario');
        document.getElementById('info-secundario').classList.add('hidden');
    }
}

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

