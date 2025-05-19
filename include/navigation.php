
  <aside class="sidebar">

    <ul class="sidebar-list">

      <li class="sidebar-element">
        
        <div class="sidebar-hide">
          <img class="sidebar-icono sidebar-icono--logo" src="../img/logo2.PNG" alt="Logo" >
        </div>
      </li>

      <li class="sidebar-element">
        <img src="../assets/tickets.svg" class="sidebar-icono" alt="Logo">
        <div class="sidebar-text">
          <p><a href="../views/inicio.php">Inicio</a></p>
        </div>
      </li>

      <li class="sidebar-element">
        <img src="../assets/estadisticas.svg" class="sidebar-icono" alt="Logo">
        <div class="sidebar-text">
            <p><a href="#">Estadisticas</a></p>
        </div>
      </li>

      <li class="sidebar-element">
        <img src="../assets/reportes.svg" class="sidebar-icono" alt="Logo">
        <div class="sidebar-text">
          <p><a href="#">Reportes</a></p>
        </div>
      </li>

      <li class="sidebar-element">
        <img src="../assets/equipos.svg" class="sidebar-icono" alt="Logo">
        <div class="sidebar-text">
            <p><a href="../views/equipos.php">Equipos</a></p>
        </div>
      </li>

      <li class="sidebar-element">
        <img src="../assets/departamentos.svg" class="sidebar-icono" alt="Logo">
        <div class="sidebar-text">
            <p><a href="../views/ubicaciones.php">Ubicaciones</a></p>
        </div>
      </li>

      <li class="sidebar-element">
        <img src="../assets/usuarios.svg" class="sidebar-icono" alt="Logo">
        <div class="sidebar-text">
            <p><a href="../views/responsables.php">Responsables</a></p>
        </div>
      </li>

      <li class="sidebar-element sidebar-footer--ele">
        <img src="../assets/configuracion.svg" class="sidebar-icono" alt="Logo">
        <div class="sidebar-text">
          <p>Configuracion</p>
        </div>
      </li>

      <li class="sidebar-element">
        <a class="sidebar-element" href="../models/logout.php" >
          <img src="../assets/cerrar-sesion.svg" class="sidebar-icono red-hover" alt="Logo">
          <div class="sidebar-text"><p>Cerrar Sesión</p></div>
        </a>
      </li>
    </ul>
  </aside>

  <nav>
    <div class="navbar">
      <ul class="navbar-list">

        <li class="navbar-element nav-right">
          <img src="../assets/menu.svg" class="navbar-icono" alt="Logo">
          <input type="text" class="navbar-input" placeholder="Buscar...">
        </li>


          <?php
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          ?>
          <li class="navbar-element nav-left">
            <div class="navbar-text">
              <p><b><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Invitado'); ?></b></p>
              <p><?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Sin rol'); ?></p>
            </div>
            <img src="../img/hombre.png" class="navbar-icono navbar-icono--logo" alt="Logo">
          </li>
      </ul>   


    </div>
  </nav>
 
