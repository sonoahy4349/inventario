

<div id="container-form" class="container-form">
  <div class="form-box">
    <h1 class="h1-form">Agregar nuevo responsable</h1>
    <form class="form-equipos" action="../models/agregar-equipos.php" method="POST">
      
      <!-- Nombre del responsable -->
      <div class="form-group">
        <label for="numero_serie" class="nombre">Nombres</label>
        <input type="text" id="numero_serie" name="numero_serie" class="input" required>
      </div>

      <!-- Apellido del responsable -->
      <div class="form-group">
        <label for="numero_serie" class="nombre">Apellidos</label>
        <input type="text" id="numero_serie" name="numero_serie" class="input" required>
      </div>

      <!-- Cargo del responsable -->
      <div class="form-group">
        <label for="estado_id" class="nombre">Cargo</label>
        <select id="estado_id" name="estado_id" required>
          <option value="" disabled selected>Selecciona un cargo</option>
        </select>
      </div>

      <!-- Area del responsable -->
    <div class="form-group">
        <label for="estado_id" class="nombre">Area</label>
        <select id="estado_id" name="estado_id" required>
          <option value="" disabled selected>Selecciona el area</option>
        </select>
      </div>

      <div class="btn-group-form">
        <button type="button" id="btn-cancelar" class="btn-cancelar">Cancelar</button>
        <button type="submit" class="btn-agregar-form">Agregar</button>
      </div>

    </form>
  </div>
</div>
    