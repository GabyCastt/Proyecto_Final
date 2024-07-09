$(document).ready(function() {
    // Manejar el envío del formulario para crear o editar publicación
    $('form').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var actionUrl = $(this).attr('action');

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Actualizar la lista de publicaciones o mostrar un mensaje de éxito
                alert('Publicación guardada exitosamente.');
                location.reload(); // Recargar la página para actualizar la lista de publicaciones
            },
            error: function() {
                alert('Ocurrió un error al guardar la publicación.');
            }
        });
    });

    // Manejar la eliminación de publicaciones
    $('.btn-danger').on('click', function(e) {
        e.preventDefault();

        if (confirm('¿Está seguro de eliminar esta publicación?')) {
            var deleteUrl = $(this).attr('href');

            $.ajax({
                url: deleteUrl,
                type: 'GET',
                success: function(response) {
                    // Actualizar la lista de publicaciones o mostrar un mensaje de éxito
                    alert('Publicación eliminada exitosamente.');
                    location.reload(); // Recargar la página para actualizar la lista de publicaciones
                },
                error: function() {
                    alert('Ocurrió un error al eliminar la publicación.');
                }
            });
        }
    });
});
