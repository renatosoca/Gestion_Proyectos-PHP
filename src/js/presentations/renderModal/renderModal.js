import { getTaskById } from "../../useCases/getTaskById";

let modal, form;
let loadedTask = {};

export const showModal = async (id) => {
  if (modal) {
    modal.classList.remove("modal__hidden");
  }
  if (!id) return;

  const task = await getTaskById(id);
  console.log(task);
  //setFormValues(task);
};

export const hiddenModal = () => {
  if (modal) {
    modal.classList.add("modal__hidden");
    form.reset();
    return;
  }
};

const setFormValues = (task) => {
  form.querySelector("#name").value = task.name;
};

export const renderModal = (element, callback) => {
  if (modal) return;

  modal = document.createElement("div");
  modal.classList.add("modal", "modal__hidden");

  form = document.createElement("form");
  form.classList.add("modal__form");
  form.innerHTML = `
    <div class="modal__header">
      <h2 class="modal__title">Editar tarea</h2>
      <button class="modal__close" type="button">X</button>
    </div>
    <div class="modal__body">
      <div class="modal__field">
        <label for="name" class="modal__field--name">Nombre</label>
        <input type="text" id="name" name="name" class="modal__field--value" placeholder="Nombre de la tarea" />
      </div>
    </div>
    <div class="modal__footer">
      <button class="modal__submit" type="submit">Guardar</button>
    </div>
  `;

  setTimeout(() => {
    const modal = document.querySelector(".modal__form");
    modal.classList.add("modal__form--show");
  }, 0);

  modal.appendChild(form);
  element.appendChild(modal);

  const btnClose = modal.querySelector(".modal__close");

  modal.addEventListener("click", (e) => {
    if (e.target.classList.contains("modal")) {
      return hiddenModal();
    }
  });
  btnClose.addEventListener("click", hiddenModal);

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const taskObject = { ...loadedTask };

    for (const [key, value] of formData) {
      taskObject[key] = value;
    }

    await callback(taskObject);
  });
};
