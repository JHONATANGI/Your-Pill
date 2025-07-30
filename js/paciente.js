import { mostrarVista } from './tool.js';

const $panel = document.getElementById('panel_general'); 

document.addEventListener("DOMContentLoaded", async () => {
    fetch('../backend/obtener_usuario.php', {
        credentials: 'include'
    })
        .then(res => res.json())
        .then(data => {
            //console.log("Datos recibidos del backend:", data); // 👈 Esto mostrará el JSON en la consola

            const nombreCompleto = `${data.nombre} ${data.apellido}`.trim();
            const span = document.getElementById('nombre-usuario');
            span.textContent = nombreCompleto || 'Paciente';
        })
        .catch(err => {
            console.error('Error al obtener el nombre:', err);
            document.getElementById('nombre-usuario').textContent = 'Paciente';
        });

    // Cargar el panel de opciones del paciente
    $panel.innerHTML = await mostrarVista('../backend/vistas/paciente.php');

});

//Evento click
document.addEventListener('click', async (e) => {
    if (e.target.matches('.btn_panel')) {
        const vista = e.target.getAttribute('data-vista');
        $panel.innerHTML = await mostrarVista(`../backend/vistas/${vista}.php`);
    }
});
