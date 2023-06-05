import { getTaskById } from "../../useCases/getTaskById";

let modal,
  form,
  editModal = false;
let loadedTask = {};

export const showModal = async (id) => {
  if (modal) {
    modal.classList.remove("modal__hidden");
  }
  if (!id) {
    setFormValues();
    return;
  }

  editModal = true;

  const task = await getTaskById(id);
  setFormValues(task);
};

export const hiddenModal = () => {
  if (modal) {
    modal.classList.add("modal__hidden");
    form.reset();
    return;
  }
};

const setFormValues = (task) => {
  form.querySelector(".modal__title").textContent = task
    ? "Editar tarea"
    : "Crear tarea";
  form.querySelector('button[type="submit"]').textContent = task
    ? "Editar tarea"
    : "Crear tarea";

  if (!task) return;
  form.querySelector("#name").value = task.name;
  loadedTask = task;
};

export const renderModal = (element, callback) => {
  if (modal) return;

  modal = document.createElement("div");
  modal.classList.add("modal", "modal__hidden");

  form = document.createElement("form");
  form.classList.add("modal__form", "modal__form--show");
  form.innerHTML = `
    <div class="modal__header">
      <h2 class="modal__title">Crear tarea</h2>
      <button class="modal__close" type="button">X</button>
    </div>
    <div class="modal__body">
      <div class="modal__field">
        <label for="name" class="modal__field--name">Nombre</label>
        <input type="text" id="name" name="name" class="modal__field--value" placeholder="Nombre de la tarea" />
      </div>
    </div>
    <div class="modal__footer">
      <button class="modal__submit" type="submit">Crear</button>
    </div>
  `;

  modal.appendChild(form);
  element.appendChild(modal);

  const btnClose = modal.querySelector(".modal__close");

  modal.addEventListener("click", ({ target }) => {
    if (target.classList.contains("modal")) {
      hiddenModal();
    }
  });
  btnClose.addEventListener("click", hiddenModal);

  //Events Form
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const taskObject = { ...loadedTask };
    for (const [key, value] of formData) {
      taskObject[key] = value;
    }

    await callback(taskObject);
    hiddenModal();
  });
};
