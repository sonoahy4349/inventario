<?php
include('../models/inicio-controller.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/dash.css">
    <link rel="stylesheet" href="../style/inicio.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    
</head>
<body>
    <?php include_once '../include/navigation.php'; ?>

    <div class="contenedor">

        <div class="header">
          <h1 class="titulo">Inicio</h1>
        </div>

    <main class="main">

            <div class="card">

                <header class="card-header">
                    <p class="card-title">Resumen de equipos</p>
                </header>

                <div class="big-box">
                <div class="box">
                <div class="card-avatar">
                    <img src="../img/equipos.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre">Total:</p>
                    <p class="cantidad"><?php echo $totalEquipos; ?></p>
                </div>
                </div>

                <div class="box separador">
                <div class="card-avatar">
                    <img src="../img/asignados.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="en-uso">En uso:</p>
                    <p class="cantidad"><?php echo $equiposEnUso; ?></p>
                </div>
                </div>
                
                <div class="box separador">
                <div class="card-avatar">
                    <img src="../img/disponibles.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="disponible">Disponible:</p>
                    <p class="cantidad"><?php echo $equiposDisponibles; ?></p>
                </div>
                </div>

                <div class="box separador">
                <div class="card-avatar">
                    <img src="../img/descompuestos.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="mantenimiento">Mantenimiento:</p>
                    <p class="cantidad"><?php echo $equiposEnMantenimiento; ?></p>
                </div>
                </div>
            </div>
        </div>

         <div class="card-usuarios">
                <header class="card-header">
                    <p class="card-title">Resumen de usuarios</p>
                </header>

                <div class="big-box">
                <div class="box-usuarios">
                <div class="card-avatar">
                    <img src="../img/usuario.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre">Total:</p>
                    <p class="cantidad">660</p>
                </div>
                </div>

                <div class="box-usuarios separador">
                <div class="card-avatar">
                    <img src="../img/asignados.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre" style="color: green;">Asignados:</p>
                    <p class="cantidad">587</p>
                </div>
                </div>

            </div>
        </div>

            <div class="card">

                <header class="card-header">
                    <p class="card-title">Resumen de ubicaciones</p>
                </header>

                <div class="big-box">
                <div class="box">
                <div class="card-avatar">
                    <img src="../img/edificio.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre">Total:</p>
                    <p class="cantidad"><?php echo $total; ?></p>
                </div>
                </div>

                <div class="box separador">
                <div class="card-avatar">
                    <img src="../img/planta.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre">Edificio:</p>
                    <p class="cantidad"><?php echo $edificios; ?></p>
                </div>
                </div>
                
                <div class="box separador">
                <div class="card-avatar">
                    <img src="../img/servicio.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre">Servicio:</p>
                    <p class="cantidad"><?php echo $servicios; ?></p>
                </div>
                </div>

                <div class="box separador">
                <div class="card-avatar">
                    <img src="../img/ubicacion.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre">Ubicacion interna:</p>
                    <p class="cantidad"><?php echo $ubicaciones_internas; ?></p>
                </div>
                </div>
            </div>
        </div>

         <div class="card-usuarios">
                <header class="card-header">
                    <p class="card-title">Resumen de responsables</p>
                </header>

                <div class="big-box">
                <div class="box-usuarios">
                <div class="card-avatar">
                    <img src="../img/responsable.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre">Total:</p>
                    <p class="cantidad">660</p>
                </div>
                </div>

                <div class="box-usuarios separador">
                <div class="card-avatar">
                    <img src="../img/asignados.png" alt="Responsable 1" width="30" height="30">
                </div>
                <div class="card-body">
                    <p class="nombre" style="color: green;">Asignados:</p>
                    <p class="cantidad">587</p>
                </div>
                </div>

            </div>
        </div>

            <div class="card-grafica">

                <header class="card-header">
                    <p class="card-title">Distibucion de equipos por area</p>
                </header>

                
                </div>


         <div class="card-movimientos">
                <header class="card-header">
                    <p class="card-title">Movimientos</p>
                </header>

            </div>
        </div>               


            </div>
        </div>




    </main>


    </div>
</body>
</html>