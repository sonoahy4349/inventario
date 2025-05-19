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
                    <tr class="tr">
                      <td>Laptop</td>
                      <td>Dell</td>
                      <td>XPS 13</td>
                      <td>123456789</td>

                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">

                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>

                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
 
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
 
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">

                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>

                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">

                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
   
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
 
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
  
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">

                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
   
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">

                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
    
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">

                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
    
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">
 
                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>
  
                      <td>
                        <div class="btn-group">
                          <button class="btn-izq"><img src="../img/pincel.png" width="24px" height="25px" class="img"></button>
                          <button class="btn-der"><img src="../img/basura.png" width="23px" height="25px" class="img"></button>
                        </div>
                      </td>
                    </tr>

                    <tr class="tr">

                      <td>Monitor</td>
                      <td>LG</td>
                      <td>UltraFine 5K</td>
                      <td>987654321</td>

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
    </div>

 
</body>
</html>