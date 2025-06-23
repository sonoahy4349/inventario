  
  <!-- Modal para filtrar equipos -->

  <section id="modal" class="modal hidden">
    <div class="modal-contenedor">

        <header class="modal-header">
            <h3>Seleccione la categoría que desea filtrar</h3>
            <button class="close-button" id="close-modal">X</button>
        </header>

        <div class="modal-body">
          <form class="form">

            <div class="pill">
                <input type="checkbox" id="checkbox-1" name="impresora" class="pill-input" hidden>
                <label for="checkbox-1" class="pill-text">Laptop</label>
            </div>

            <div class="pill">
                <input type="checkbox" id="checkbox-2" name="impresora" class="pill-input" hidden>
                <label for="checkbox-2" class="pill-text">Monitor</label>
            </div>

            <div class="pill">
                <input type="checkbox" id="checkbox-3" name="impresora" class="pill-input" hidden>
                <label for="checkbox-3" class="pill-text">Pc</label>
            </div>

            <div class="pill">
                <input type="checkbox" id="checkbox-4" name="impresora" class="pill-input" hidden>
                <label for="checkbox-4" class="pill-text">Impresora</label>
            </div>

            <div class="pill">
                <input type="checkbox" id="checkbox-5" name="impresora" class="pill-input" hidden>
                <label for="checkbox-5" class="pill-text">Telefono</label>
            </div>

            <div class="pill">
                <input type="checkbox" id="checkbox-6" name="impresora" class="pill-input" hidden>
                <label for="checkbox-6" class="pill-text">Teclado</label>
            </div>

            <div class="pill">
                <input type="checkbox" id="checkbox-7" name="impresora" class="pill-input" hidden>
                <label for="checkbox-7" class="pill-text">Ratón</label>
            </div>
            
            <div class="pill">
                <input type="checkbox" id="checkbox-8" name="impresora" class="pill-input" hidden>
                <label for="checkbox-8" class="pill-text">Otro</label>
            </div>

            <hr class="divider">

            <div class="modal-footer">
                <button type="submit" class="btn">Aplicar</button>
            </div>
            
          </form>

      
        </div>
          
  </section>

    <!-- Modal para filtrar marcas -->
    
  <section id="modal-marca" class="modal-marca hidden">
    <div class="modal-contenedor">

        <header class="modal-header">
            <h3>Seleccione la marca que desea filtrar</h3>
            <button class="close-button" id="close-modal-marca">X</button>
        </header>

        <div class="modal-body">
          <form class="form">

            <label class="pill">
                <input type="checkbox" name="HP" class="pill-input" hidden>
                <span class="pill-text">HP</span>
            </label>


            <label class="pill">
                <input type="checkbox" name="Lenovo" class="pill-input" hidden>
                <span class="pill-text">Lenovo</span>
            </label>

            <label class="pill">
                <input type="checkbox" name="Samsung" class="pill-input" hidden>
                <span class="pill-text">Samsung</span>
            </label>

            <label class="pill">
                <input type="checkbox" name="Acer" class="pill-input" hidden>
                <span class="pill-text">Acer</span>
            </label>

             <label class="pill">
                <input type="checkbox" name="Asus" class="pill-input" hidden>
                <span class="pill-text">Asus</span>
            </label>

            <label class="pill">
                <input type="checkbox" name="Apple" class="pill-input" hidden>
                <span class="pill-text">Apple</span>
            </label>

            <label class="pill">
                <input type="checkbox" name="huawei" class="pill-input" hidden>
                <span class="pill-text">Huawei</span>
            </label>
            
            <label class="pill">
                <input type="checkbox" name="otro" class="pill-input" hidden>
                <span class="pill-text">Otro</span>
            </label>

            <hr class="divider">

            <div class="modal-footer">
                <button type="submit" class="btn">Aplicar</button>
            </div>
            
          </form>

      
        </div>
          
  </section>

      <!-- Modal para filtrar estados -->

  <section id="modal-estado" class="modal-estado hidden">
    <div class="modal-contenedor">

        <header class="modal-header">
            <h3>Seleccione el estado que desea filtrar</h3>
            <button class="close-button" id="close-modal-estado">X</button>
        </header>

        <div class="modal-body">
          <form class="form">

            <label class="pill">
                <input type="checkbox" name="Lenovo" class="pill-input" hidden>
                <span class="pill-text">En uso</span>
            </label>

            <label class="pill">
                <input type="checkbox" name="Samsung" class="pill-input" hidden>
                <span class="pill-text">Disponible</span>
            </label>

            <label class="pill">
                <input type="checkbox" name="Acer" class="pill-input" hidden>
                <span class="pill-text">Mantenimiento</span>
            </label>
            
            <label class="pill">
                <input type="checkbox" name="otro" class="pill-input" hidden>
                <span class="pill-text">Otro</span>
            </label>

            <hr class="divider">

            <div class="modal-footer">
                <button type="submit" class="btn">Aplicar</button>
            </div>
            
          </form>

        </div>
          
  </section>