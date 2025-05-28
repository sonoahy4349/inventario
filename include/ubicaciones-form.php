<?php include '../models/conexion.php'; ?>

<div id="container-form" class="container-form hidden">
  <div class="form-box">
    <h1 class="h1-form">Crear nueva ubicación</h1>
    <form class="form-equipos" id="f-ubicaciones" action="../models/crear-ubicacion.php" method="POST">
      
      <!-- Edificio -->
      <div class="form-group">
        <label for="edificio_nombre" class="nombre">Nombre del Edificio</label>
        <input type="text" id="edificio_nombre" name="edificio_nombre" class="input" placeholder="Ej: A1, B, Torre Norte" required>
      </div>

      <!-- Número de plantas -->
      <div class="form-group">
        <label for="numero_plantas" class="nombre">Número de Plantas</label>
        <input type="number" id="numero_plantas" name="numero_plantas" class="input" min="1" max="50" placeholder="Ej: 4" required>
        
      </div>

      <!-- Servicio -->
      <div class="form-group">
        <label for="servicio_nombre" class="nombre">Nombre del Servicio</label>
        <input type="text" id="servicio_nombre" name="servicio_nombre" class="input" placeholder="Ej: Administración, Recursos Humanos" required>
      </div>

      <!-- Ubicación Interna -->
      <div class="form-group">
        <label for="ubicacion_interna_nombre" class="nombre">Ubicación Interna</label>
        <input type="text" id="ubicacion_interna_nombre" name="ubicacion_interna_nombre" class="input" placeholder="Ej: Oficina 101, Sala de Juntas" required>
      </div>

      <!-- Planta específica donde se ubicará -->
      <div class="form-group">
        <label for="planta_especifica" class="nombre">Planta donde se ubicará</label>
        <select id="planta_especifica" name="planta_especifica" required>
          <option value="" disabled selected>Primero ingresa el número de plantas</option>
        </select>
       
      </div>

      <div class="btn-group-form">
        <button type="button" id="btn-cancelar-ubicacion" class="btn-cancelar">Cancelar</button>
        <button type="submit" class="btn-agregar-form">Añadir</button> 
      </div>

    </form>
  </div>
</div>

<script>
// Script para generar opciones de plantas dinámicamente
document.getElementById('numero_plantas').addEventListener('input', function() {
    const numeroplantas = parseInt(this.value);
    const plantaSelect = document.getElementById('planta_especifica');
    
    // Limpiar el select
    plantaSelect.innerHTML = '';
    
    if (numeroplantas && numeroplantas > 0) {
        plantaSelect.innerHTML = '<option value="" disabled selected>Selecciona una planta</option>';
        
        // Agregar Planta Baja (nivel 0)
        plantaSelect.innerHTML += '<option value="0">Planta Baja</option>';
        
        // Agregar pisos del 1 al número ingresado - 1
        for (let i = 1; i < numeroplantas; i++) {
            plantaSelect.innerHTML += `<option value="${i}">Piso ${i}</option>`;
        }
    } else {
        plantaSelect.innerHTML = '<option value="" disabled selected>Primero ingresa el número de plantas</option>';
    }
});

// Validación y envío con AJAX + recarga si éxito
document.querySelector('.form-equipos').addEventListener('submit', function(e) {
    e.preventDefault(); // evitar envío tradicional

    const numeroplantas = parseInt(document.getElementById('numero_plantas').value);
    const plantaEspecifica = document.getElementById('planta_especifica').value;

    if (!plantaEspecifica) {
        alert('Por favor selecciona la planta específica donde se ubicará.');
        return;
    }

    if (parseInt(plantaEspecifica) >= numeroplantas) {
        alert('La planta seleccionada no puede ser mayor o igual al número total de plantas.');
        return;
    }

    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            location.reload(); // recarga la página al éxito
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error en la solicitud: ' + error.message);
    });
});
</script>
