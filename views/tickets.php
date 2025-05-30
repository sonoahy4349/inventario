<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="database" href="./conexion.php">
        <link rel="stylesheet" href="../style/dash.css">
        <link rel="stylesheet" href="../style/tickets.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    </head>

<body>
  <?php include_once '../include/navigation.php'; ?>
 
  <div class="main-container">

    <header class="main-header">
      <h2>Tickets</h2>
    </header>


  <div class="wrapper">
    <div class="filter-container">

      <div class="filter">

      <button class="filter-btn">+ Crear Ticket</button>

      <ul class="filter-list">
        <h5 class="list-header">Mi espacio</h5>

        <li class="filter-element">
          <img src="../assets/cupon.svg" class="main-filter-icono" alt="Logo">
          <p>Todos</p>
          <p class="filter-number">99+</p>
        </li>

        <li class="filter-element">
          <img src="../assets/estrella.svg" class="main-filter-icono" alt="Logo">
          <p>Guardados</p>
          <p class="filter-number">99+</p>
        </li>

        <li class="filter-element">
          <img src="../assets/pendiente.svg" class="main-filter-icono" alt="Logo">
          <p>Pendientes</p>
          <p class="filter-number">99+</p>
        </li>

        <li class="filter-element">
          <img src="../assets/resuelto.svg" class="main-filter-icono" alt="Logo">
          <p>Resueltos</p>
          <p class="filter-number">99+</p>
        </li>

        <li class="filter-element">
          <img src="../assets/papelera.svg" class="main-filter-icono" alt="Logo">
          <p>Papelera</p>
          <p class="filter-number">99+</p>
        </li>

        <h5 class="list-header">Etiquetas</h5>

        <li class="filter-element">
          <input type="checkbox" class="checkbox" id="checkbox1">
          <label for="checkbox1" class="checkbox-label">Resueltos</label>
        </li>
        <li class="filter-element">
          <input type="checkbox" class="checkbox" id="checkbox2">
          <label for="checkbox2" class="checkbox-label">Abiertos</label>
        </li>
        <li class="filter-element">
          <input type="checkbox" class="checkbox" id="checkbox3">
          <label for="checkbox3" class="checkbox-label">Pendientes</label>
        </li>
        <li class="filter-element">
          <input type="checkbox" class="checkbox" id="checkbox4">
          <label for="checkbox4" class="checkbox-label">######</label>
        </li>
      </ul>

      <a href="#" class="filter-link">+ Crear una nueva etiqueta</a>
    </div>
    </div>

    <main class="tabla-principal"> <!-- Cuerpo del contenedor de la tabla entera -->
    <div class="tabla-wrapper">

      <table class="tabla-header"> <!-- Encabezado de la tabla -->
        <thead>
          <tr>
            <th class="th">Ticket</th>
            <th class="th">Responsable</th>
            <th class="th">Asunto</th>
            <th class="th">Fecha</th>
            <th class="th">Estado</th>
            <th class="th">Acción</th>
          </tr>
        </thead>         
      </table>

    <div class="tabla-scroll"> <!-- Cuerpo de la tabla con datos dinámicos -->
      <table class="tabla-body">
        <tbody>
           <tr class="tr" id="fila-equipo">
              <td>#4349</td>
              <td>Miriam</td>
              <td>Impresora sin tinta</td>
              <td>05-12-2001</td>
              <td>Abierto</td>
        <td>
          <div class="btn-group" id="equipo-">
              <button class="btn-izq">
                  <img src="../img/pincel.png" width="24px" height="25px" class="img">
              </button>

              <button class="btn-der">
                  <img src="../img/basura.png" width="23px" height="25px" class="img">
              </button>
          </div>
        </td>
      </tr>
                
      <tr class="tr" id="fila-equipo">
              <td>#4349</td>
              <td>Miriam</td>
              <td>Impresora sin tinta</td>
              <td>05-12-2001</td>
              <td>Abierto</td>
        <td>
          <div class="btn-group" id="equipo-">
              <button class="btn-izq">
                  <img src="../img/pincel.png" width="24px" height="25px" class="img">
              </button>

              <button class="btn-der">
                  <img src="../img/basura.png" width="23px" height="25px" class="img">
              </button>
          </div>
        </td>
      </tr>

        </tbody>


   </div>
  </div>
 
</body>
</html>
