$(document).ready(function() {
    $('#form-comentario').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
            url: '../controllers/comentarios.controller.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var res = JSON.parse(response);
                if(res.status === 'success') {
                    // Agregar el nuevo comentario a la lista
                    var nuevoComentario = '<li class="mb-3 bg-white p-3 rounded">' +
                        '<strong>' + res.nombre_usuario + ':</strong>' +
                        '<p>' + res.contenido + '</p>' +
                        '<small class="text-muted">Fecha: ' + res.fecha_comentario + '</small>' +
                        '</li>';
                    $('#comentarios-lista ul').append(nuevoComentario);
                    
                    // Limpiar el textarea
                    $('#contenido').val('');
                } else {
                    alert('Error al agregar el comentario');
                }
            },
            error: function() {
                alert('Error en la solicitud AJAX');
            }
        });
    });
});