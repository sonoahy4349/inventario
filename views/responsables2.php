<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsables</title>
    <link rel="stylesheet" href="../style/dash.css">
    <link rel="stylesheet" href="../style/responsables2.css">
    <link rel="stylesheet" href="../style/ubicaciones-form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    
</head>
<body>
    <?php include_once '../include/navigation.php'; ?>

    <div class="contenedor">
        <div class="header">
          <h1 class="titulo">Responsables</h1>
        </div>

        <div class="filtros">
          <div class="flitro-contenedor-icono">
            <img class="filtro-icono" src="../img/filtro.png" alt="Filtro" width="28px" height="28px">
          </div>

          <div class="filtro-elementos">
            <p class="filtro-texto">Filtrar por:</p>

            <p class="filtro-texto">Cargo</p>
            <select id="filtro-cargo" class="filtro-select">
                <option value="">Todos los cargos</option>
            </select>

            <input type="text" id="filtro-buscar" placeholder="Buscar por nombre..." class="filtro-input">

            <img class="reiniciar-filtro" src="../img/reiniciar.png" alt="reiniciar" onclick="limpiarFiltros()">

            <button class="btn-imprimir" id="btn-imprimir">Imprimir lista</button>
            <button class="btn-agregar" id="btn-agregar-responsable">Agregar</button>
          </div>

        </div>

    <main class="tabla-principal">
        <div class="tabla-wrapper">
            <table class="tabla-header">
                <thead>
                    <tr>
                        <th class="th">ID</th>
                        <th class="th">Nombres</th>
                        <th class="th">Apellidos</th>
                        <th class="th">Cargo</th>
                        <th class="th">Acción</th>
                    </tr>
                </thead>
            </table>

            <div class="tabla-scroll">
                <table class="tabla-body">
                    <tbody id="tabla-responsables">
                        <!-- Los datos se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        <div class="paginacion" id="paginacion">
            <!-- Los controles de paginación se generarán aquí -->
        </div>
         
      </main>
      <?php include_once '../include/responsables-form.php'; ?>
    </div>

    <script>
        let paginaActual = 1;
        const registrosPorPagina = 10;
        let filtroActivo = '';
        let cargoFiltro = '';

        // Cargar datos al iniciar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarResponsables();
            cargarCargos();
            
            // Event listeners para filtros
            document.getElementById('filtro-cargo').addEventListener('change', aplicarFiltros);
            document.getElementById('filtro-buscar').addEventListener('input', aplicarFiltros);
        });

        function cargarResponsables(pagina = 1) {
            const xhr = new XMLHttpRequest();
            const params = new URLSearchParams({
                pagina: pagina,
                registros_por_pagina: registrosPorPagina,
                filtro: filtroActivo,
                cargo: cargoFiltro
            });

            xhr.open('GET', '../models/obtener_responsables.php?' + params.toString(), true);
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            mostrarResponsables(response.data);
                            crearPaginacion(response.total_registros, pagina);
                        } else {
                            console.error('Error:', response.message);
                        }
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                    }
                }
            };
            
            xhr.send();
        }

        function cargarCargos() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../models/obtener_cargos.php', true);
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            const select = document.getElementById('filtro-cargo');
                            response.data.forEach(cargo => {
                                const option = document.createElement('option');
                                option.value = cargo.id_cargo;
                                option.textContent = cargo.nombre_cargo;
                                select.appendChild(option);
                            });
                        }
                    } catch (e) {
                        console.error('Error al cargar cargos:', e);
                    }
                }
            };
            
            xhr.send();
        }

        function mostrarResponsables(responsables) {
            const tbody = document.getElementById('tabla-responsables');
            tbody.innerHTML = '';

            if (responsables.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No se encontraron responsables</td></tr>';
                return;
            }

            responsables.forEach(responsable => {
                const tr = document.createElement('tr');
                tr.className = 'tr';
                tr.innerHTML = `
                    <td>${responsable.id_responsable}</td>
                    <td>${responsable.nombre}</td>
                    <td>${responsable.apellidos}</td>
                    <td>${responsable.nombre_cargo || 'Sin cargo'}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn-izq" onclick="editarResponsable(${responsable.id_responsable})">
                                <img src="../img/pincel.png" width="24px" height="25px" class="img">
                            </button>
                            <button class="btn-der" onclick="eliminarResponsable(${responsable.id_responsable})">
                                <img src="../img/basura.png" width="23px" height="25px" class="img">
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        function crearPaginacion(totalRegistros, paginaActualParam) {
            const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
            const contenedorPaginacion = document.getElementById('paginacion');
            
            if (totalPaginas <= 1) {
                contenedorPaginacion.innerHTML = '';
                return;
            }

            let paginacionHTML = '<div class="paginacion-container">';
            
            // Información de registros
            paginacionHTML += `<div class="paginacion-info">Mostrando ${Math.min((paginaActualParam - 1) * registrosPorPagina + 1, totalRegistros)} - ${Math.min(paginaActualParam * registrosPorPagina, totalRegistros)} de ${totalRegistros} registros</div>`;
            
            // Controles de paginación
            paginacionHTML += '<div class="paginacion-controles">';
            
            // Botón Anterior
            if (paginaActualParam > 1) {
                paginacionHTML += `<a href="#" class="paginacion-btn" onclick="cambiarPagina(${paginaActualParam - 1}); return false;">‹ Anterior</a>`;
            } else {
                paginacionHTML += '<span class="paginacion-btn deshabilitado">‹ Anterior</span>';
            }

            // Lógica para mostrar números de página
            const maxBotones = 5;
            let inicio = Math.max(1, paginaActualParam - Math.floor(maxBotones / 2));
            let fin = Math.min(totalPaginas, inicio + maxBotones - 1);
            
            // Ajustar el inicio si no hay suficientes páginas al final
            if (fin - inicio < maxBotones - 1) {
                inicio = Math.max(1, fin - maxBotones + 1);
            }
            
            // Primera página y puntos suspensivos
            if (inicio > 1) {
                paginacionHTML += `<a href="#" class="paginacion-btn" onclick="cambiarPagina(1); return false;">1</a>`;
                if (inicio > 2) {
                    paginacionHTML += '<span class="paginacion-puntos">...</span>';
                }
            }
            
            // Páginas numeradas
            for (let i = inicio; i <= fin; i++) {
                if (i === paginaActualParam) {
                    paginacionHTML += `<span class="paginacion-btn activo">${i}</span>`;
                } else {
                    paginacionHTML += `<a href="#" class="paginacion-btn" onclick="cambiarPagina(${i}); return false;">${i}</a>`;
                }
            }
            
            // Última página y puntos suspensivos
            if (fin < totalPaginas) {
                if (fin < totalPaginas - 1) {
                    paginacionHTML += '<span class="paginacion-puntos">...</span>';
                }
                paginacionHTML += `<a href="#" class="paginacion-btn" onclick="cambiarPagina(${totalPaginas}); return false;">${totalPaginas}</a>`;
            }
            
            // Botón Siguiente
            if (paginaActualParam < totalPaginas) {
                paginacionHTML += `<a href="#" class="paginacion-btn" onclick="cambiarPagina(${paginaActualParam + 1}); return false;">Siguiente ›</a>`;
            } else {
                paginacionHTML += '<span class="paginacion-btn deshabilitado">Siguiente ›</span>';
            }

            paginacionHTML += '</div></div>';

            contenedorPaginacion.innerHTML = paginacionHTML;
        }

        function cambiarPagina(pagina) {
            paginaActual = pagina;
            cargarResponsables(pagina);
        }

        function aplicarFiltros() {
            filtroActivo = document.getElementById('filtro-buscar').value;
            cargoFiltro = document.getElementById('filtro-cargo').value;
            paginaActual = 1;
            cargarResponsables(1);
        }

        function limpiarFiltros() {
            document.getElementById('filtro-buscar').value = '';
            document.getElementById('filtro-cargo').value = '';
            filtroActivo = '';
            cargoFiltro = '';
            paginaActual = 1;
            cargarResponsables(1);
        }

        function editarResponsable(id) {
            // Aquí puedes implementar la lógica para editar
            console.log('Editar responsable ID:', id);
            // Por ejemplo, abrir un modal o redirigir a una página de edición
        }

        function eliminarResponsable(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este responsable?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../models/eliminar_responsable.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                alert('Responsable eliminado exitosamente');
                                cargarResponsables(paginaActual);
                            } else {
                                alert('Error: ' + response.message);
                            }
                        } catch (e) {
                            console.error('Error al eliminar:', e);
                        }
                    }
                };
                
                xhr.send('id=' + id);
            }
        }
    </script>
 
</body>
</html>