$(document).ready(function() {
    $('#form-comentario').submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '../controllers/comentarios.controller.php',
            data: formData,
            dataType: 'json',
            encode: true
        })
        .done(function(response) {
            if (response && response.success) {
                // Comentario creado exitosamente
                // Actualizar la lista de comentarios
                $('#comentario-container').append('<div class="comment">' +
                    '<div class="comment-content">' +
                    '<strong>' + (response.nombreCompleto || 'Usuario') + ':</strong>' +
                    '<p>' + response.contenido + '</p>' +
                    '</div>' +
                    '<div class="comment-meta">Fecha: ' + (response.fecha_comentario || 'Ahora') + '</div>' +
                    '</div>');

                // Limpiar el campo de texto del formulario
                $('#contenido').val('');

                // Mostrar mensaje de éxito
                alert(response.message || 'Comentario creado correctamente.');
            } else {
                // Manejar errores
                alert(response.message || 'Error desconocido al enviar comentario.');
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error AJAX:", textStatus, errorThrown);
            alert('Error al conectar con el servidor. Por favor, inténtelo de nuevo.');
        });
    });
});