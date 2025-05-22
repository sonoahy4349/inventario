<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/dash.css">
    <link rel="stylesheet" href="../style/equipos.css">
    <link rel="stylesheet" href="../style/modal-filtro-equipo.css">
    <link rel="stylesheet" href="../style/equipos-form.css">
 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">

  </head>

<body>
    <?php include_once '../include/navigation.php'; ?>

    <div class="contenedor">

        <div class="header">
          <h1 class="titulo">Equipos</h1>
        </div>

        <div class="filtros">
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
            <button class="btn-agregar" id="btn-agregar">Agregar equipo</button>
          </div>

        </div>

          <main class="tabla-principal">
            <div class="tabla-wrapper">

              <table class="tabla-header">
                <thead>
                  <tr>
                    <th class="th">ID</th>
                    <th class="th">Equipo</th>
                    <th class="th">Marca</th>
                    <th class="th">Modelo</th>
                    <th class="th">No. de serie</th>
                    <th class="th">Estado</th>
                    <th class="th">Acción</th>
                  </tr>
                </thead>
              </table>

              <div class="tabla-scroll">
                <table class="tabla-body">
                  <tbody>
                    <tr class="tr">
                      <th>1</th> 
                      <td>Laptop</td>
                      <td>Dell</td>
                      <td>XPS 13</td>
                      <td>123456789</td>
                      <td class="Estado"><span class="disponible">Disponible</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="en-uso">En uso</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="en-uso">En uso</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="en-uso">En uso</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="en-uso">En uso</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="en-uso">En uso</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span id="en-us" class="en-uso">En uso</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="disponible">Disponible</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="mantenimiento">Mantenimiento</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="en-uso">En uso</span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
                      <td>2</td>
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
                      <td class="Estado"><span class="en-uso"><span class="en-uso-texto">En uso</span></span></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </main>

          <?php include_once '../include/modal-filtro-equipo.php'; ?>
          <?php include_once '../include/modal-filtro-marca.php'; ?>
          <?php include_once '../include/equipos-form.php'; ?>


    </div>

    <script>

 document.addEventListener('DOMContentLoaded', () => {
  // Primer modal
  const modal = document.getElementById('modal');
  const openModalButton = document.getElementById('f-equipo');
  const closeModalButton = document.getElementById('close-modal');

  openModalButton.addEventListener('click', () => {
    modal.classList.remove('hidden');
  });

  closeModalButton.addEventListener('click', () => {
    modal.classList.add('hidden');
  });


  const modalMarca = document.getElementById('modal-marca');
  const openModalMarcaButton = document.getElementById('f-marca');
  const closeModalMarcaButton = document.getElementById('close-modal-marca');

  openModalMarcaButton.addEventListener('click', () => {
    modalMarca.classList.remove('hidden'); // CORREGIDO
  });

  closeModalMarcaButton.addEventListener('click', () => {
    modalMarca.classList.add('hidden'); // CORREGIDO
  });


  // Segundo modal (form)
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
<script src="../js/equipo.js"></script>
</html>