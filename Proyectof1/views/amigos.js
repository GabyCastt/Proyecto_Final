$(document).ready(function() {
    // Función para cargar la lista de amigos al cargar la página
    function cargarListaAmigos() {
        $.ajax({
            url: '../controllers/amigos.controller.php',
            method: 'GET',
            success: function(response) {
                // Limpiar la lista actual de amigos
                $('#listaAmigos').empty();

                // Iterar sobre la respuesta para mostrar cada amigo
                response.forEach(function(amigo) {
                    $('#listaAmigos').append(`
                        <div class="amigo">
                            <p>ID: ${amigo.id_amigo}</p>
                            <p>Nombre: ${amigo.nombre}</p>
                            <p>Apellido: ${amigo.apellido}</p>
                            <button class="eliminarAmigo" data-id="${amigo.id_amigo}">Eliminar</button>
                        </div>
                    `);
                });

                // Asignar evento al botón de eliminar amigo
                $('.eliminarAmigo').click(function() {
                    var idAmigo = $(this).data('id');
                    eliminarAmigo(idAmigo);
                });
            },
            error: function(err) {
                console.error('Error al cargar la lista de amigos:', err);
            }
        });
    }

    // Cargar la lista de amigos al cargar la página
    cargarListaAmigos();

    // Manejar el envío del formulario para agregar amigo
    $('#formAgregarAmigo').submit(function(event) {
        event.preventDefault();
        var idUsuario2 = $('#idUsuario2').val();
        agregarAmigo(idUsuario2);
    });

    // Función para agregar un amigo
    function agregarAmigo(idUsuario2) {
        $.ajax({
            url: '../controllers/amigos.controller.php',
            method: 'POST',
            data: { id_usuario2: idUsuario2 },
            success: function(response) {
                // Recargar la lista de amigos después de agregar uno nuevo
                cargarListaAmigos();
                // Limpiar el campo del formulario
                $('#idUsuario2').val('');
            },
            error: function(err) {
                console.error('Error al agregar amigo:', err);
            }
        });
    }

    // Función para eliminar un amigo
    function eliminarAmigo(idAmigo) {
        $.ajax({
            url: '../controllers/amigos.controller.php',
            method: 'POST',
            data: { id_amigo: idAmigo },
            success: function(response) {
                // Recargar la lista de amigos después de eliminar uno
                cargarListaAmigos();
            },
            error: function(err) {
                console.error('Error al eliminar amigo:', err);
            }
        });
    }
});
