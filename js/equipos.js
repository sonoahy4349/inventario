 // funcion eliminar equipo 
 
 function eliminarEquipo(id) {
    if (!confirm("¿Estás seguro de que deseas eliminar este equipo?")) return;

    const formData = new FormData();
    formData.append("accion", "eliminar");
    formData.append("id", id);

    fetch("../models/equipos-controller.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const div = document.getElementById("equipo-" + id);
            if (div) div.remove();
            alert("Equipo eliminado correctamente.");
            location.reload();
        } else {
            console.error(data.error);
            alert("Ocurrió un error al eliminar el equipo.");
        }
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
        alert("Fallo de conexión.");
    });
}

 
 
 document.addEventListener('DOMContentLoaded', () => {
  // Primer modal (filtro equipos)
  const modal = document.getElementById('modal');
  const openModalButton = document.getElementById('f-equipo');
  const closeModalButton = document.getElementById('close-modal');

  openModalButton.addEventListener('click', () => {
    modal.classList.remove('hidden'); //abre modal equipos
  });

  closeModalButton.addEventListener('click', () => {
    modal.classList.add('hidden'); //cierra modal equipos
  });

  // Segundo modal (filtro marca)
  const modalMarca = document.getElementById('modal-marca');
  const openModalMarcaButton = document.getElementById('f-marca');
  const closeModalMarcaButton = document.getElementById('close-modal-marca');

  openModalMarcaButton.addEventListener('click', () => {
    modalMarca.classList.remove('hidden'); //abre modal marca
  });

  closeModalMarcaButton.addEventListener('click', () => {
    modalMarca.classList.add('hidden'); //cierra modal marca
  });

    // Tercer modal modal (filtro estado)
  const modalEstado = document.getElementById('modal-estado');
  const openModalEstadoButton = document.getElementById('f-estado');
  const closeModalEstadoButton = document.getElementById('close-modal-estado');

  openModalEstadoButton.addEventListener('click', () => {
    modalEstado.classList.remove('hidden'); //abre modal estado
  });

  closeModalEstadoButton.addEventListener('click', () => {
    modalEstado.classList.add('hidden'); //cierra modal estado
  });

  // modal (form)
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

