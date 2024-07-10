document.addEventListener("DOMContentLoaded", function () {
  listarMiembros();
  cargarGrupos();
  cargarUsuarios();

  document
    .getElementById("frm_miembros")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      guardarMiembro();
    });
});

function listarMiembros() {
  fetch("../controllers/miembros_grupos.controller.php", {
    method: "POST",
    body: new URLSearchParams({
      action: "listarMiembros",
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const cuerpoMiembros = document.getElementById("cuerpoMiembros");
        cuerpoMiembros.innerHTML = "";
        data.data.forEach((miembro) => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
                    <td>${miembro.id_miembro}</td>
                    <td>${miembro.nombre_grupo}</td>
                    <td>${miembro.nombre} ${miembro.apellido}</td>
                    <td>${miembro.fecha_union}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editarMiembro(${miembro.id_miembro})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarMiembro(${miembro.id_miembro})">Eliminar</button>
                    </td>
                `;
          cuerpoMiembros.appendChild(tr);
        });
      } else {
        Swal.fire("Error", data.message, "error");
      }
    });
}

function cargarGrupos() {
  fetch("../controllers/miembros_grupos.controller.php", {
      method: "POST",
      body: new URLSearchParams({
          action: "obtenerGrupos",
      }),
  })
  .then((response) => {
      if (!response.ok) {
          throw new Error(`Error en la solicitud: ${response.status} ${response.statusText}`);
      }
      return response.json();
  })
  .then((data) => {
      if (data.status === "success") {
          const grupoSelect = document.getElementById("id_grupo");
          grupoSelect.innerHTML = "";
          data.data.forEach((grupo) => {
              const option = document.createElement("option");
              option.value = grupo.id_grupo;
              option.textContent = grupo.nombre_grupo;
              grupoSelect.appendChild(option);
          });
      } else {
          console.error("Error al cargar grupos:", data.message);
          Swal.fire("Error", data.message, "error");
      }
  })
  .catch((error) => {
      console.error("Error en la solicitud:", error);
      Swal.fire("Error", "Error al cargar grupos", "error");
  });
}
function cargarUsuarios() {
  fetch("../controllers/miembros_grupos.controller.php", {
    method: "POST",
    body: new URLSearchParams({
      action: "obtenerUsuarios",
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const usuarioSelect = document.getElementById("id_usuario");
        usuarioSelect.innerHTML = "";
        data.data.forEach((usuario) => {
          const option = document.createElement("option");
          option.value = usuario.id_usuario;
          option.textContent = usuario.nombre_completo;
          usuarioSelect.appendChild(option);
        });
      } else {
        Swal.fire("Error", data.message, "error");
      }
    });
}

function abrirModalMiembro(tipo) {
  document.getElementById("frm_miembros").reset();
  document.getElementById("id_miembro").value = "";
  document.getElementById("exampleModalLabel").innerText =
    tipo === "insertar" ? "Nuevo Miembro" : "Editar Miembro";
  $("#modalMiembro").modal("show");
}

function guardarMiembro() {
  const formData = new FormData(document.getElementById("frm_miembros"));
  formData.append(
    "action",
    document.getElementById("id_miembro").value
      ? "editarMiembro"
      : "insertarMiembro"
  );

  fetch("../controllers/miembros_grupos.controller.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        $("#modalMiembro").modal("hide");
        listarMiembros();
        Swal.fire("Éxito", data.message, "success");
      } else {
        Swal.fire("Error", data.message, "error");
      }
    });
}

function editarMiembro(id_miembro) {
  fetch("../controllers/miembros_grupos.controller.php", {
    method: "POST",
    body: new URLSearchParams({
      action: "obtenerMiembro",
      id_miembro: id_miembro,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        document.getElementById("id_miembro").value = data.data.id_miembro;
        document.getElementById("id_grupo").value = data.data.id_grupo;
        document.getElementById("id_usuario").value = data.data.id_usuario;
        document.getElementById("fecha_union").value = data.data.fecha_union;
        abrirModalMiembro("editar");
      } else {
        Swal.fire("Error", data.message, "error");
      }
    });
}

function eliminarMiembro(id_miembro) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("../controllers/miembros_grupos.controller.php", {
        method: "POST",
        body: new URLSearchParams({
          action: "eliminarMiembro",
          id_miembro: id_miembro,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            listarMiembros();
            Swal.fire("Eliminado", data.message, "success");
          } else {
            Swal.fire("Error", data.message, "error");
          }
        });
    }
  });
}