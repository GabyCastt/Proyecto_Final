document.addEventListener('DOMContentLoaded', function() {
    const formRegistro = document.getElementById('form-registro');
    const errorMessage = document.getElementById('error-message');

    formRegistro.addEventListener('submit', function(event) {
        event.preventDefault();

        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const correo = document.getElementById('correo').value.trim();
        const contrasena = document.getElementById('contrasena').value;
        const confirmarContrasena = document.getElementById('confirmar_contrasena').value;

        if (!nombre || !apellido || !correo || !contrasena || !confirmarContrasena) {
            errorMessage.textContent = 'Todos los campos son obligatorios';
            return;
        }

        if (contrasena !== confirmarContrasena) {
            errorMessage.textContent = 'Las contraseñas no coinciden';
            return;
        }

        if (contrasena.length < 6) {
            errorMessage.textContent = 'La contraseña debe tener al menos 6 caracteres';
            return;
        }

        const formData = {
            nombre: nombre,
            apellido: apellido,
            correo: correo,
            contrasena: contrasena
        };

        fetch('../controllers/usuario_registro.controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                errorMessage.textContent = '';
                alert(data.message);
                formRegistro.reset();
            } else {
                errorMessage.textContent = data.message || 'Error en el registro';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorMessage.textContent = 'Error al procesar la solicitud: ' + error.message;
        });
    });
});