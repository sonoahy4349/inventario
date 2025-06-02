<?php include '../models/conexion.php'; ?>

<div id="container-form" class="container-form hidden">
  <div class="form-box">
    <h1 class="h1-form">Agregar nuevo equipo</h1>
    <form class="form-equipos" action="../models/equipos-controller.php" method="POST">
    <input type="hidden" name="accion" value="agregar">
      
      <!-- Tipo de equipo -->
      <div class="form-group">
        <label for="tipo_id" class="nombre">Equipo</label>
        <select id="tipo_id" name="tipo_id" required>
          <option value="" disabled selected>Selecciona un equipo</option>
          <?php
          $sql = "SELECT id, nombre FROM equipo_tipo";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
          }
          ?>
        </select>
      </div>

      <!-- Marca -->
      <div class="form-group">
        <label for="marca_id" class="nombre">Marca</label>
        <select id="marca_id" name="marca_id" required>
          <option value="" disabled selected>Selecciona una marca</option>
          <?php
          $sql = "SELECT id, nombre FROM equipo_marca";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
          }
          ?>
        </select>
      </div>

      <!-- Modelo -->
      <div class="form-group">
        <label for="modelo" class="nombre">Modelo</label>
        <input type="text" id="modelo" name="modelo" class="input" required>
      </div>

      <!-- Número de serie -->
      <div class="form-group">
        <label for="numero_serie" class="nombre">No. de serie</label>
        <input type="text" id="numero_serie" name="numero_serie" class="input" required>
      </div>

      <!-- Estado -->
      <div class="form-group">
        <label for="estado_id" class="nombre">Estado</label>
        <select id="estado_id" name="estado_id" required>
          <option value="" disabled selected>Selecciona un estado</option>
          <?php
          $sql = "SELECT id, nombre FROM estados_equipo";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
          }
          ?>
        </select>
      </div>

      <div class="btn-group-form">
        <button type="button" id="btn-cancelar" class="btn-cancelar">Cancelar</button>
        <button type="submit" class="btn-agregar-form">Agregar</button>
      </div>

    </form>
  </div>
</div>
