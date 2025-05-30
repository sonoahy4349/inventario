<div id="container-form" class="container-form hidden">
  <div class="form-box">
    <h1 class="h1-form">Agregar nuevo responsable</h1>
    <img src="../img/responsable-banner.png" alt="Responsable Banner" class="form-banner" style="width: auto; height: 130px;">   
    <form class="form-equipos" action="../models/agregar-responsables.php" method="POST">
      
      <!-- Nombre del responsable -->
      <div class="form-group">
        <label for="nombre" class="nombre">Nombres</label>
        <input type="text" id="nombre" name="nombre" class="input" required>
      </div>

      <!-- Apellido del responsable -->
      <div class="form-group">
        <label for="apellidos" class="nombre">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" class="input" required>
      </div>

      <!-- Cargo del responsable -->
      <div class="form-group">
        <label for="id_cargo" class="nombre">Cargo</label>
        <select id="id_cargo" name="id_cargo" required>
          <option value="" disabled selected>Selecciona un cargo</option>
          <!-- Los cargos se cargarán aquí dinámicamente -->
        </select>
      </div>

      <div class="btn-group-form">
        <button type="button" id="btn-cancelar" class="btn-cancelar">Cancelar</button>
        <button type="submit" class="btn-agregar-form">Agregar</button>
      </div>

    </form>
  </div>
</div>

<script>
// Función para cargar los cargos en el select
async function cargarCargos() {
    try {
        const response = await fetch('../models/obtener-cargos.php');
        const cargos = await response.json();
        
        const select = document.getElementById('id_cargo');
        
        // Limpiar opciones existentes (excepto la primera)
        select.innerHTML = '<option value="" disabled selected>Selecciona un cargo</option>';
        
        // Agregar cada cargo al select
        cargos.forEach(cargo => {
            const option = document.createElement('option');
            option.value = cargo.id_cargo;
            option.textContent = cargo.nombre_cargo;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error al cargar cargos:', error);
    }
}

// Cargar cargos cuando se carga la página
document.addEventListener('DOMContentLoaded', cargarCargos);
</script>