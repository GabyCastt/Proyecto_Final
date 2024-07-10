$(document).ready(function() {
    $('#buscarUsuario').on('input', function() {
        let busqueda = $(this).val();
        if (busqueda.length > 2) {
            $.ajax({
                url: '../controllers/amigos.controller.php',
                method: 'POST',
                data: { accion: 'buscar', busqueda: busqueda },
                success: function(response) {
                    $('#resultadosBusqueda').html(response);
                }
            });
        } else {
            $('#resultadosBusqueda').html('');
        }
    });

    $(document).on('click', '.agregarAmigo', function() {
        let id_usuario2 = $(this).data('id');
        $.ajax({
            url: '../controllers/amigos.controller.php',
            method: 'POST',
            data: { accion: 'agregar', id_usuario2: id_usuario2 },
            success: function(response) {
                if (response === 'success') {
                    alert('Amigo agregado correctamente');
                    location.reload();
                } else {
                    alert('Error al agregar amigo');
                }
            }
        });
    });

    $('.eliminarAmigo').click(function() {
        let id_usuario2 = $(this).data('id');
        if (confirm('¿Estás seguro de que quieres eliminar a este amigo?')) {
            $.ajax({
                url: '../controllers/amigos.controller.php',
                method: 'POST',
                data: { accion: 'eliminar', id_usuario2: id_usuario2 },
                success: function(response) {
                    if (response === 'success') {
                        alert('Amigo eliminado correctamente');
                        location.reload();
                    } else {
                        alert('Error al eliminar amigo');
                    }
                }
            });
        }
    });
});