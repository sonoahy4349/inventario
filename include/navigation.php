          <?php
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          ?>
          
  <aside class="sidebar">

    <ul class="sidebar-list">

      <li class="sidebar-element helpdesk">
          <img class="sidebar-icono--logo" src="../img/logo2.PNG" alt="Logo" >
      </li>

      <li class="sidebar-element">
        <a href="../views/inicio.php" class="sidebar-link">
          <img src="../img/inicio.png" class="sidebar-icono" alt="Icono Inicio">
          <span class="sidebar-text">Inicio</span>
        </a>
      </li>

      <li class="sidebar-element">
        <a href="../views/tickets.php" class="sidebar-link">
          <img src="../assets/cupon.svg" class="sidebar-icono" alt="Icono Inicio">
          <span class="sidebar-text">Tickets</span>
        </a>
      </li>

      <li class="sidebar-element">
        <a href="#" class="sidebar-link">
          <img src="../assets/estadisticas.svg" class="sidebar-icono" alt="Icono Estadisticas">
          <span class="sidebar-text">Estadisticas</span>
        </a>
      </li>

      <li class="sidebar-element">
        <a href="#" class="sidebar-link">
          <img src="../assets/reportes.svg" class="sidebar-icono" alt="Icono Inicio">
          <span class="sidebar-text">Resguardos</span>
        </a>
      </li>

      <li class="sidebar-element">
        <a href="../views/equipos.php" class="sidebar-link">
          <img src="../assets/equipos.svg" class="sidebar-icono" alt="Icono Inicio">
          <span class="sidebar-text">Equipos</span>
        </a>
      </li>

      <li class="sidebar-element">
        <a href="../views/ubicaciones.php" class="sidebar-link">
          <img src="../assets/departamentos.svg" class="sidebar-icono" alt="Icono Inicio">
          <span class="sidebar-text">Ubicaciones</span>
        </a>
      </li>

      <li class="sidebar-element">
        <a href="../views/responsables.php" class="sidebar-link">
          <img src="../assets/usuarios.svg" class="sidebar-icono" alt="Icono Inicio">
          <span class="sidebar-text">Responsables</span>
        </a>
      </li>

      <li class="sidebar-element sidebar-footer--ele">
        <a href="#" class="sidebar-link">
          <img src="../assets/configuracion.svg" class="sidebar-icono" alt="Icono Inicio">
          <span class="sidebar-text">configuracion</span>
        </a>
      </li>

      <li class="sidebar-element">
        <a href="../models/logout.php" class="sidebar-link red-hover">
          <img src="../assets/cerrar-sesion.svg" class="sidebar-icono" alt="Icono Cerrar sesión">
          <span class="sidebar-text">Cerrar sesión</span>
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
 
