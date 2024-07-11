// Función auxiliar para manejar las respuestas de fetch
function handleFetchResponse(response) {
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    const contentType = response.headers.get("content-type");
    if (contentType && contentType.indexOf("application/json") !== -1) {
        return response.json();
    } else {
        return response.text().then(text => {
            throw new Error(`Respuesta no válida del servidor: ${text}`);
        });
    }
}

// Usar esta función en todas tus llamadas fetch. Por ejemplo:

function crearGrupo() {
    const nombre = document.getElementById('nombreGrupo').value;
    const descripcion = document.getElementById('descripcionGrupo').value;
    fetch('../controllers/miembros_grupos.controller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `accion=crearGrupo&nombre=${encodeURIComponent(nombre)}&descripcion=${encodeURIComponent(descripcion)}`
    })
    .then(handleFetchResponse)
    .then(resultado => {
        if (resultado.success) {
            alert('Grupo creado con éxito');
            cargarGrupos();
        } else {
            alert('Error al crear grupo: ' + resultado.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud: ' + error.message);
    });
}

// Modifica todas las demás funciones que usan fetch de manera similar