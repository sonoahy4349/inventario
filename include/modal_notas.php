<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir conexión a la base de datos
require_once '../models/conexion.php'; // Ajusta la ruta según tu estructura

// Obtener el equipo_id de la URL o variable de sesión
$equipo_id = isset($_GET['equipo_id']) ? (int)$_GET['equipo_id'] : 0;

// Obtener información del equipo
$equipo_info = null;
if ($equipo_id > 0) {
    try {
        $sql_equipo = "SELECT e.*, et.nombre as tipo_nombre, em.nombre as marca_nombre 
                       FROM equipos e 
                       LEFT JOIN equipo_tipo et ON e.tipo_id = et.id 
                       LEFT JOIN equipo_marca em ON e.marca_id = em.id 
                       WHERE e.id = ?";
        $stmt = $conn->prepare($sql_equipo);
        $stmt->bind_param("i", $equipo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $equipo_info = $result->fetch_assoc();
        $stmt->close();
    } catch (Exception $e) {
        error_log("Error al obtener información del equipo: " . $e->getMessage());
    }
}

// Obtener usuario logueado (ajusta según tu sistema de sesiones)
$usuario_logueado = isset($_SESSION['usuario_id']) ? (int)$_SESSION['usuario_id'] : 0;
$nombre_usuario = isset($_SESSION['nombre_completo']) ? $_SESSION['nombre_completo'] : 
                 (isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'Usuario');

// Verificar que el usuario está logueado
if ($usuario_logueado <= 0) {
    // Redirigir al login o mostrar error
    // header('Location: login.php');
    // exit;
    // Por ahora usamos valores por defecto para testing
    $usuario_logueado = 1;
    $nombre_usuario = 'Usuario de Prueba';
}
?>

<div class="modal-notas-form modal-notas-form-overlay" id="modalNotasEquipo">
    <div class="modal-notas-form-modal">
        <button class="modal-notas-form-close-btn" onclick="closeNotasModal()">&times;</button>
        
        <!-- Sidebar con lista de notas -->
        <div class="modal-notas-form-sidebar">
            <div class="modal-notas-form-sidebar-header">
                <h3>NOTAS</h3>
                <button class="modal-notas-form-add-note-btn" onclick="addNewNote()">
                    + Añadir nueva nota
                </button>
            </div>
            <div class="modal-notas-form-equipment-info" id="equipmentInfo">
                <!-- Se cargará dinámicamente -->
            </div>
            <div class="modal-notas-form-notes-list" id="notesList">
                <!-- Se carga dinámicamente con JavaScript -->
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="modal-notas-form-main-content">
            <div class="modal-notas-form-content-header">
                <h2 id="contentTitle">Selecciona una nota</h2>
            </div>

            <!-- Contenido dinámico -->
            <div id="contentArea" class="modal-notas-form-form-container">
                <div class="modal-notas-form-empty-state">
                    <span style="font-size: 48px;">📝</span>
                    <h3>Selecciona una nota para ver sus detalles</h3>
                    <p>O crea una nueva nota usando el botón superior</p>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="modal-notas-form-form-actions" id="formActions" style="display: none;">
                <button class="modal-notas-form-btn modal-notas-form-btn-secondary" onclick="cancelNote()">Cancelar</button>
                <button class="modal-notas-form-btn modal-notas-form-btn-primary" onclick="saveNote()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentMode = 'view'; // 'view', 'edit', 'new'
    let currentNoteId = null;
    let currentEquipoInfo = null; // Para almacenar la info del equipo actual
    const usuarioId = <?php echo $usuario_logueado; ?>;
    const nombreUsuario = "<?php echo htmlspecialchars($nombre_usuario); ?>";

    function openNotasModal(equipoIdParam = null) {
        // Si se pasa un equipo ID, actualizarlo
        if (equipoIdParam && equipoIdParam > 0) {
            window.equipoId = equipoIdParam;
            console.log('Modal abierto para equipo ID:', equipoIdParam);
            
            // Cargar información del equipo
            loadEquipmentInfo(equipoIdParam);
        } else {
            window.equipoId = <?php echo $equipo_id; ?>;
            // Si ya tenemos info del equipo desde PHP, usarla
            <?php if ($equipo_info): ?>
            currentEquipoInfo = {
                id: <?php echo $equipo_info['id']; ?>,
                tipo_nombre: "<?php echo htmlspecialchars($equipo_info['tipo_nombre'] ?? 'N/A'); ?>",
                marca_nombre: "<?php echo htmlspecialchars($equipo_info['marca_nombre'] ?? 'N/A'); ?>",
                modelo: "<?php echo htmlspecialchars($equipo_info['modelo'] ?? 'N/A'); ?>",
                numero_serie: "<?php echo htmlspecialchars($equipo_info['numero_serie'] ?? 'N/A'); ?>"
            };
            updateEquipmentInfoDisplay();
            <?php endif; ?>
        }
        
        document.getElementById('modalNotasEquipo').classList.add('show');
        loadNotesList();
    }

    function loadEquipmentInfo(equipoId) {
        fetch('../ajax/get_equipo_info.php?id=' + equipoId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentEquipoInfo = data.equipo;
                    updateEquipmentInfoDisplay();
                    console.log('Información del equipo cargada:', currentEquipoInfo);
                } else {
                    console.error('Error al cargar información del equipo:', data.message);
                    currentEquipoInfo = null;
                    updateEquipmentInfoDisplay();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                currentEquipoInfo = null;
                updateEquipmentInfoDisplay();
            });
    }

    function updateEquipmentInfoDisplay() {
        const equipmentInfo = document.getElementById('equipmentInfo');
        if (currentEquipoInfo) {
            equipmentInfo.innerHTML = `
                <h4>Equipo Seleccionado:</h4>
                <p><strong>Tipo:</strong> ${currentEquipoInfo.tipo_nombre || 'N/A'}</p>
                <p><strong>Marca:</strong> ${currentEquipoInfo.marca_nombre || 'N/A'}</p>
                <p><strong>Modelo:</strong> ${currentEquipoInfo.modelo || 'N/A'}</p>
                <p><strong>Serie:</strong> ${currentEquipoInfo.numero_serie || 'N/A'}</p>
            `;
        } else {
            equipmentInfo.innerHTML = `
                <div style="text-align: center; color: #dc3545; padding: 10px; font-size: 12px;">
                    No se ha seleccionado un equipo válido
                </div>
            `;
        }
    }

    function closeNotasModal() {
        document.getElementById('modalNotasEquipo').classList.remove('show');
    }

    function loadNotesList() {
        const currentEquipoId = window.equipoId;
        console.log('Cargando notas para equipo ID:', currentEquipoId);
        
        if (!currentEquipoId || currentEquipoId <= 0) {
            document.getElementById('notesList').innerHTML = `
                <div style="text-align: center; color: #dc3545; padding: 20px; font-size: 14px;">
                    No se ha seleccionado un equipo válido
                </div>
            `;
            return;
        }

        fetch('../ajax/get_notas_equipo.php?equipo_id=' + currentEquipoId)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                const notesList = document.getElementById('notesList');
                if (data.success && data.notas && data.notas.length > 0) {
                    notesList.innerHTML = '';
                    data.notas.forEach(nota => {
                        const noteItem = document.createElement('div');
                        noteItem.className = 'modal-notas-form-note-item';
                        noteItem.onclick = () => selectNote(nota.id);
                        noteItem.innerHTML = `
                            <div class="modal-notas-form-note-title">${nota.titulo || 'Sin título'}</div>
                            <div class="modal-notas-form-note-date">${nota.fecha_creacion || ''} - ${nota.hora_creacion || ''}</div>
                        `;
                        notesList.appendChild(noteItem);
                    });
                } else {
                    notesList.innerHTML = `
                        <div style="text-align: center; color: #6c757d; padding: 20px; font-size: 14px;">
                            No hay notas para este equipo
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                document.getElementById('notesList').innerHTML = `
                    <div style="text-align: center; color: #dc3545; padding: 20px; font-size: 14px;">
                        Error al cargar las notas: ${error.message}
                    </div>
                `;
            });
    }

    function addNewNote() {
        const currentEquipoId = window.equipoId;
        console.log('Intentando añadir nueva nota. Equipo ID:', currentEquipoId);
        console.log('Info del equipo actual:', currentEquipoInfo);
        
        if (!currentEquipoId || currentEquipoId <= 0) {
            alert('No se ha seleccionado un equipo válido. Equipo ID: ' + currentEquipoId);
            return;
        }

        if (!currentEquipoInfo) {
            alert('No se ha cargado la información del equipo. Por favor, intenta nuevamente.');
            return;
        }

        currentMode = 'new';
        currentNoteId = null;
        
        // Actualizar título
        document.getElementById('contentTitle').textContent = 'Nueva nota';
        
        // Limpiar selección
        document.querySelectorAll('.modal-notas-form-note-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Mostrar formulario para nueva nota
        const contentArea = document.getElementById('contentArea');
        const now = new Date();
        const currentDate = now.toLocaleDateString('es-ES');
        const currentTime = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        
        contentArea.innerHTML = `
            <div class="modal-notas-form-form-row">
                <div class="modal-notas-form-form-group">
                    <label>Creada por:</label>
                    <input type="text" class="modal-notas-form-form-control" value="${nombreUsuario}" disabled>
                </div>
                <div class="modal-notas-form-form-group">
                    <label>Fecha:</label>
                    <input type="text" class="modal-notas-form-form-control" value="${currentDate}" disabled>
                </div>
            </div>
            <div class="modal-notas-form-form-row">
                <div class="modal-notas-form-form-group">
                    <label>Equipo asignado:</label>
                    <input type="text" class="modal-notas-form-form-control" value="${currentEquipoInfo.numero_serie || 'N/A'}" disabled>
                </div>
                <div class="modal-notas-form-form-group">
                    <label>Hora:</label>
                    <input type="text" class="modal-notas-form-form-control" value="${currentTime}" disabled>
                </div>
            </div>
            <div class="modal-notas-form-form-row">
                <div class="modal-notas-form-form-group">
                    <label>Título de la nota:</label>
                    <input type="text" class="modal-notas-form-form-control" id="noteTitle" placeholder="Ingresa el título de la nota" required>
                </div>
                <div class="modal-notas-form-form-group">
                </div>
            </div>
            <div class="modal-notas-form-textarea-container">
                <label>Descripción:</label>
                <textarea class="modal-notas-form-form-control" id="noteDescription" placeholder="Describe los detalles de la nota..."></textarea>
            </div>
        `;
        
        document.getElementById('formActions').style.display = 'flex';
    }

    function selectNote(noteId) {
        currentMode = 'view';
        currentNoteId = noteId;
        
        fetch('../ajax/get_nota_detalle.php?id=' + noteId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const note = data.nota;
                    
                    // Actualizar selección visual
                    document.querySelectorAll('.modal-notas-form-note-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    
                    // Encontrar el elemento clickeado correctamente
                    const noteItems = document.querySelectorAll('.modal-notas-form-note-item');
                    noteItems.forEach(item => {
                        if (item.onclick.toString().includes(noteId)) {
                            item.classList.add('active');
                        }
                    });
                    
                    // Actualizar título
                    document.getElementById('contentTitle').textContent = note.titulo;
                    
                    // Mostrar detalles de la nota
                    const contentArea = document.getElementById('contentArea');
                    contentArea.innerHTML = `
                        <div class="modal-notas-form-form-row">
                            <div class="modal-notas-form-form-group">
                                <label>Creada por:</label>
                                <input type="text" class="modal-notas-form-form-control" value="${note.nombre_usuario || 'N/A'}" disabled>
                            </div>
                            <div class="modal-notas-form-form-group">
                                <label>Fecha:</label>
                                <input type="text" class="modal-notas-form-form-control" value="${note.fecha_creacion || 'N/A'}" disabled>
                            </div>
                        </div>
                        <div class="modal-notas-form-form-row">
                            <div class="modal-notas-form-form-group">
                                <label>Equipo asignado:</label>
                                <input type="text" class="modal-notas-form-form-control" value="${note.numero_serie || 'N/A'}" disabled>
                            </div>
                            <div class="modal-notas-form-form-group">
                                <label>Hora:</label>
                                <input type="text" class="modal-notas-form-form-control" value="${note.hora_creacion || 'N/A'}" disabled>
                            </div>
                        </div>
                        <div class="modal-notas-form-form-row">
                            <div class="modal-notas-form-form-group">
                                <label>Título de la nota:</label>
                                <input type="text" class="modal-notas-form-form-control" value="${note.titulo || ''}" disabled>
                            </div>
                            <div class="modal-notas-form-form-group">
                            </div>
                        </div>
                        <div class="modal-notas-form-textarea-container">
                            <label>Descripción:</label>
                            <textarea class="modal-notas-form-form-control" disabled>${note.descripcion || ''}</textarea>
                        </div>
                    `;
                    
                    document.getElementById('formActions').style.display = 'none';
                } else {
                    alert('Error al cargar la nota: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar la nota: ' + error.message);
            });
    }

    function saveNote() {
        const title = document.getElementById('noteTitle').value.trim();
        const description = document.getElementById('noteDescription').value.trim();
        
        if (!title) {
            alert('Por favor ingresa un título para la nota');
            document.getElementById('noteTitle').focus();
            return;
        }
        
        const formData = new FormData();
        formData.append('equipo_id', window.equipoId);
        formData.append('usuario_id', usuarioId);
        formData.append('titulo', title);
        formData.append('descripcion', description);
        
        console.log('Enviando datos:', {
            equipo_id: window.equipoId,
            usuario_id: usuarioId,
            titulo: title,
            descripcion: description
        });
        
        fetch('../ajax/save_nota_equipo.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Nota guardada exitosamente');
                loadNotesList(); // Recargar la lista
                cancelNote(); // Limpiar el formulario
            } else {
                alert('Error al guardar la nota: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar la nota: ' + error.message);
        });
    }

    function cancelNote() {
        if (currentMode === 'new') {
            // Volver al estado inicial
            document.getElementById('contentTitle').textContent = 'Selecciona una nota';
            document.getElementById('contentArea').innerHTML = `
                <div class="modal-notas-form-empty-state">
                    <span style="font-size: 48px;">📝</span>
                    <h3>Selecciona una nota para ver sus detalles</h3>
                    <p>O crea una nueva nota usando el botón superior</p>
                </div>
            `;
            document.getElementById('formActions').style.display = 'none';
            currentMode = 'view';
            currentNoteId = null;
        }
    }

    // Debug para verificar las variables
    console.log('Variables iniciales:');
    console.log('Usuario ID:', usuarioId);
    console.log('Nombre Usuario:', nombreUsuario);
    console.log('Equipo Info:', currentEquipoInfo);
</script>