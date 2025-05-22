<div id="container-form" class="container-form hidden">

      <div class="form-box">

        <h1 class="h1-form">Agregar nuevo equipo</h1>

        <form class="form-equipos" action="../controller/equipos-controller.php" method="POST">

          <div class="form-group">
            <label for="equipo" class="nombre">Equipo</label>
            <select id="equipo" name="equipo" required>
              <option value="" disabled selected>Selecciona un equipo</option>
              <option value="computadora">Computadora</option>
              <option value="computadora">Laptop</option>
              <option value="monitor">Monitor</option>
              <option value="teclado">Teclado</option>
              <option value="mouse">Mouse</option>
              <option value="impresora">Impresora</option>
            </select>
          </div>

          <div class="form-group">
            <label for="equipo" class="nombre">Marca</label>
            <select id="equipo" name="equipo" required>
              <option value="" disabled selected>Selecciona un marca</option>
              <option value="computadora">Lenovo</option>
              <option value="computadora">HP</option>
              <option value="monitor">Samsung</option>
              <option value="teclado">Kingston</option>
              <option value="mouse">Adata</option>
              <option value="impresora">Xpg</option>
            </select>
          </div>

          <div class="form-group">
            <label for="nombre" class="nombre">Modelo</label>
            <input type="text" id="nombre" name="nombre" class="input" required>
          </div>

          <div class="form-group">
            <label for="nombre" class="nombre">No. de serie</label>
            <input type="text" id="nombre" name="nombre" class="input" required>
          </div>

          <div class="form-group">
            <label for="equipo" class="nombre">Estado</label>
            <select id="equipo" name="equipo" required>
              <option value="" disabled selected>Selecciona un estado</option>
              <option value="computadora">En uso</option>
              <option value="computadora">Disponible</option>
              <option value="monitor">Mantenimiento</option>
            </select>
          </div>

          <div class="btn-group-form">
            <button type="submit" id= "btn-cancelar" class="btn-cancelar">Cancelar</button>
            <button type="submit" class="btn-agregar-form">Agregar</button>
          </div>

        </form>
        </div>
    </div>
