// Función para cargar la lista de amigos
function cargarListaAmigos() {
    $.ajax({
        url: '../controllers/amigos.controller.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                mostrarAmigos(response.data);
            } else {
                alert('Error al cargar la lista de amigos');
            }
        },
        error: function () {
            alert('Error de red al cargar la lista de amigos');
        }
    });
}

// Función para mostrar los amigos en la tabla
function mostrarAmigos(amigos) {
    var html = '';
    amigos.forEach(function (amigo, index) {
        html += '<tr>';
        html += '<td>' + (index + 1) + '</td>';
        html += '<td>' + amigo.nombre + '</td>';
        html += '<td>';
        html += '<button type="button" class="btn btn-sm btn-info" onclick="abrirModal(\'editar\', ' + amigo.id_amigo + ')">Editar</button>';
        html += '<button type="button" class="btn btn-sm btn-danger ms-1" onclick="eliminarAmigo(' + amigo.id_amigo + ')">Eliminar</button>';
        html += '</td>';
        html += '</tr>';
    });
    $('#cuerpoamigos').html(html);
}

// Función para abrir el modal para insertar o editar amigo
function abrirModal(tipo, id_amigo = null) {
    $('#frm_amigos')[0].reset(); // Limpiar el formulario antes de abrir el modal

    if (tipo === 'editar' && id_amigo) {
        // Edición: Obtener los datos del amigo por su ID mediante AJAX
        $.ajax({
            url: '../controllers/amigos.controller.php',
            method: 'GET',
            data: { AmigoId: id_amigo },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    var amigo = response.data;
                    $('#id_amigo').val(amigo.id_amigo);
                    $('#nombre_amigo').val(amigo.nombre);
                    // Aquí puedes asignar otros campos del formulario si es necesario
                    $('#modalAmigo').modal('show');
                } else {
                    alert('Error al cargar los datos del amigo');
                }
            },
            error: function () {
                alert('Error de red al cargar los datos del amigo');
            }
        });
    } else {
        // Inserción: Abrir el modal directamente
        $('#modalAmigo').modal('show');
    }
}

// Función para eliminar un amigo
function eliminarAmigo(id_amigo) {
    $.ajax({
        url: '../controllers/amigos.controller.php',
        method: 'DELETE',
        data: JSON.stringify({ id_amigo: id_amigo }),
        dataType: 'json',
        contentType: 'application/json',
        success: function (response) {
            if (response.status === 'success') {
                cargarListaAmigos();
            } else {
                alert('Error al eliminar amigo');
            }
        },
        error: function () {
            alert('Error de red al eliminar amigo');
        }
    });
}

// Función para enviar datos del formulario de amigo mediante AJAX
$('#frm_amigos').submit(function (event) {
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: '../controllers/amigos.controller.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#modalAmigo').modal('hide');
                cargarListaAmigos();
            } else {
                alert('Error al guardar amigo');
            }
        },
        error: function () {
            alert('Error de red al guardar amigo');
        }
    });
});

// Document Ready: Cargar lista de amigos al cargar la página
$(document).ready(function () {
    cargarListaAmigos();
});
