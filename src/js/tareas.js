(function () {
  obtenerTareas();
  let tareas = [];
  let filtradas = [];

  const nuevaTarea = document.querySelector("#agregar-tarea");
  nuevaTarea.addEventListener("click", () => {
    mostrarFormulario();
  });

  const filtros = document.querySelectorAll('#filtros input[type="radio"');
  filtros.forEach((radio) => {
    radio.addEventListener("input", (e) => {
      const filtro = e.target.value;

      if (filtro === "") {
        filtradas = [];
        mostrarTareas();
        return;
      }

      filtradas = tareas.filter((tarea) => tarea.estado === filtro);
      mostrarTareas();
    });
  });

  async function obtenerTareas() {
    try {
      const token = obtenerProyecto();
      const url = `/api/v1/tasks/${token}`;
      const respuesta = await fetch(url);
      const resultado = await respuesta.json();

      tareas = resultado;
      mostrarTareas();
    } catch (error) {
      console.log(error);
    }
  }

  function mostrarTareas() {
    limpiarTareas();
    totalPendientes();
    totalCompletas();

    const arrayTareas = filtradas.length ? filtradas : tareas;

    const listaTareas = document.querySelector("#listado-tareas");

    if (arrayTareas.length === 0) {
      const textoNoTareas = document.createElement("li");
      textoNoTareas.textContent = "No hay tareas";
      textoNoTareas.classList.add("no-tareas");
      listaTareas.appendChild(textoNoTareas);
      return;
    }

    const estados = {
      0: "Pendiente",
      1: "Completo",
    };

    arrayTareas.forEach((tarea) => {
      const { id, nombre, estado } = tarea;

      const contenedorTarea = document.createElement("li");
      contenedorTarea.dataset.tareaId = id;
      contenedorTarea.classList.add("tarea");

      const nombreTarea = document.createElement("p");
      nombreTarea.textContent = nombre;
      nombreTarea.ondblclick = () => {
        //Editar el nombre de la tarea
        mostrarFormulario(true, { ...tarea });
      };

      const opcionesDiv = document.createElement("div");
      opcionesDiv.classList.add("opciones");

      const btnEstado = document.createElement("button");
      btnEstado.classList.add(
        "estado-tarea",
        `${estados[estado].toLowerCase()}`
      );
      btnEstado.textContent = estados[estado];
      btnEstado.dataset.estadoTarea = estado;
      //Evento de doble click
      btnEstado.ondblclick = () => {
        cambiarEstadoTarea({ ...tarea });
      };

      const btnEliminar = document.createElement("button");
      btnEliminar.classList.add("eliminar-tarea");
      btnEliminar.dataset.idTarea = id;
      btnEliminar.textContent = "Eliminar";
      btnEliminar.ondblclick = () => {
        confirmarEliminarTarea({ ...tarea });
      };

      opcionesDiv.appendChild(btnEstado);
      opcionesDiv.appendChild(btnEliminar);

      contenedorTarea.appendChild(nombreTarea);
      contenedorTarea.appendChild(opcionesDiv);

      listaTareas.appendChild(contenedorTarea);
    });
  }

  function totalPendientes() {
    const totalPendientes = tareas.filter((tarea) => tarea.estado === "0");
    const PendientesRadio = document.querySelector("#pendiente");

    if (totalPendientes.length === 0) {
      PendientesRadio.disabled = true;
      return;
    }

    PendientesRadio.disabled = false;
  }

  function totalCompletas() {
    const totalCompletas = tareas.filter((tarea) => tarea.estado === "1");
    const completasRadio = document.querySelector("#completas");

    if (totalCompletas.length === 0) {
      completasRadio.disabled = true;
      return;
    }

    completasRadio.disabled = false;
  }

  function mostrarFormulario(editar = false, tarea = {}) {
    const { id, nombre } = tarea;

    const modal = document.createElement("div");
    modal.classList.add("modal");
    modal.innerHTML = `
            <form class='formulario nueva-tarea'>
                <legend>${
                  editar ? "Editar Tarea" : "Añade una nueva tarea"
                }</legend>
                <div class='campo'>
                    <label for='tarea'>Tarea</label>
                    <input type='text' name='tarea' id='tarea' placeholder='${
                      nombre ? "Editar la Tarea" : "Escribe la Tarea"
                    }' value='${nombre ? nombre : ""}'>
                </div>

                <div class='opciones'>
                    <input type='submit' class='submit-nueva-tarea' value='${
                      editar ? "Actualizar Tarea" : "Crear Tarea"
                    }'>
                    <button type='button' class='cerrar-modal'>Cancelar</button>
                </div>
            </form>
        `;

    setTimeout(() => {
      const formulario = document.querySelector(".formulario");
      formulario.classList.add("animar");
    }, 0);

    document.querySelector("body").appendChild(modal);

    modal.addEventListener("click", (e) => {
      e.preventDefault();

      if (e.target.classList.contains("cerrar-modal")) {
        const formulario = document.querySelector(".formulario");
        formulario.classList.add("cerrar");
        setTimeout(() => {
          modal.remove();
        }, 500);
      }

      if (e.target.classList.contains("submit-nueva-tarea")) {
        const nombreTarea = document.querySelector("#tarea").value.trim();

        if (nombreTarea === "") {
          //Mostrar Alerta de Error
          mostrarAlerta(
            "El nombre de la tarea es obligatorio",
            "error",
            document.querySelector(".formulario legend")
          );
          return;
        }

        if (editar) {
          tarea.nombre = nombreTarea;
          actualizarTarea(tarea);
          return;
        }

        agregarTarea(nombreTarea);
      }
    });
  }

  function mostrarAlerta(mensaje, tipo, elemento) {
    const alertaPrevia = document.querySelector(".alertas");
    if (alertaPrevia) {
      alertaPrevia.remove();
    }

    const alerta = document.createElement("div");
    alerta.classList.add("alertas", tipo);
    alerta.textContent = mensaje;

    //Inserta la alerta antes del div"CAMPO"
    elemento.parentElement.insertBefore(alerta, elemento.nextElementSibling);

    setTimeout(() => {
      alerta.remove();
    }, 2000);
  }

  function cambiarEstadoTarea(tarea) {
    console.log(tarea);
    const nuevoEstado = tarea.estado === "1" ? "0" : "1";
    tarea.estado = nuevoEstado;
    actualizarTarea(tarea);
  }

  function confirmarEliminarTarea(tarea) {
    Swal.fire({
      title: "Eliminar Tarea?",
      text: "Se eliminará la tarea por completo!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Eliminar!",
    }).then((result) => {
      if (result.isConfirmed) {
        eliminarTarea(tarea);
      }
    });
  }

  async function eliminarTarea(tarea) {
    const { estado, id, nombre } = tarea;

    const datos = new FormData();
    datos.append("id", id);
    datos.append("nombre", nombre);
    datos.append("estado", estado);
    datos.append("proyectoId", obtenerProyecto());

    try {
      const url = "http://localhost:3000/api/tarea/eliminar";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      const resultado = await respuesta.json();

      if (resultado.tipo === "exito") {
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Eliminado",
          showConfirmButton: false,
          timer: 1000,
        });
        tareas = tareas.filter((tareaMemoria) => tareaMemoria.id !== id);
        mostrarTareas();
      }
    } catch (error) {
      console.log(error);
    }
  }

  async function actualizarTarea(tarea) {
    const { estado, id, nombre } = tarea;

    const datos = new FormData();
    datos.append("id", id);
    datos.append("nombre", nombre);
    datos.append("estado", estado);
    datos.append("proyectoId", obtenerProyecto());

    try {
      const url = "http://localhost:3000/api/tarea/actualizar";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      const resultado = await respuesta.json();

      if (resultado.tipo === "exito") {
        const modal = document.querySelector(".modal");
        if (modal) modal.remove();

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Actualizado Correctamente",
          showConfirmButton: false,
          timer: 1500,
        });

        tareas = tareas.map((tareaMemoria) => {
          if (tareaMemoria.id === id) {
            tareaMemoria.estado = estado;
            tareaMemoria.nombre = nombre;
          }
          return tareaMemoria;
        });

        mostrarTareas();
      }
    } catch (error) {
      console.log(error);
    }
  }

  async function agregarTarea(tarea) {
    const datos = new FormData();
    datos.append("name", tarea);
    datos.append("project_id", obtenerProyecto());

    try {
      const url = "http://localhost:3000/api/v1/task/create";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      const resultado = await respuesta.json();

      mostrarAlerta(
        resultado.mensaje,
        resultado.tipo,
        document.querySelector(".formulario legend")
      );

      if (resultado.tipo === "exito") {
        const modal = document.querySelector(".modal");
        setTimeout(() => {
          modal.remove();
        }, 2000);

        const tareaObj = {
          id: String(resultado.id),
          nombre: tarea,
          estado: "0",
          proyectoId: resultado.proyectoId,
        };

        tareas = [...tareas, tareaObj];
        mostrarTareas();
      }
    } catch (error) {
      console.log(error);
    }
  }

  function obtenerProyecto() {
    const projectName = window.location.href;
    const proyecto = projectName.split("/")[4];
    return proyecto;
  }

  function limpiarTareas() {
    const listadoTareas = document.querySelector("#listado-tareas");
    while (listadoTareas.firstChild) {
      listadoTareas.removeChild(listadoTareas.firstChild);
    }
  }
})();
