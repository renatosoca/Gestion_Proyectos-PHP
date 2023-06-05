import taskStore from "../../../store/taskStore";
import { deleteTaskById } from "../../useCases/deleteTaskById";
import { getTaskById } from "../../useCases/getTaskById";
import { showModal } from "../renderModal/renderModal";

let list;
const listStatus = {
  pending: "Pendiente",
  completed: "Completado",
};

const createListTasks = () => {
  const listTasks = document.createElement("ul");
  listTasks.classList.add("list__tasks");

  return listTasks;
};

const taskSelected = async (e) => {
  const btnEdit = e.target.closest(".select_task");
  if (!btnEdit) return;

  const idTask = btnEdit.dataset.idTask;

  showModal(idTask);
};

const deleteTask = async (e, projectId) => {
  const btnDelete = e.target.closest(".delete_task");
  if (!btnDelete) return;

  const idTask = btnDelete.dataset.idTask;
  try {
    await deleteTaskById(idTask, projectId);
    await taskStore.reloadPage(projectId);

    renderTasks();
  } catch (error) {
    console.log(error);
  }
};

export const renderTasks = (element, projectId) => {
  const tasks = taskStore.getTasks(taskStore.getCurrentFilter());

  if (!list) {
    list = createListTasks();
    element.appendChild(list);

    list.addEventListener("click", taskSelected);
    list.addEventListener("click", (event) => deleteTask(event, projectId));
  }

  while (list.firstChild) {
    list.removeChild(list.firstChild);
  }

  if (tasks.length === 0) {
    const taskElement = document.createElement("li");
    taskElement.textContent = "No hay tareas";
    taskElement.classList.add("task__empty");
    list.appendChild(taskElement);
    return;
  }

  tasks.forEach((task) => {
    const { id, name, status } = task;

    const taskElement = document.createElement("li");
    taskElement.classList.add("task");
    taskElement.dataset.idTask = id;
    taskElement.innerHTML = `
      <p class="task__name select_task" data-id-task="${id}">${name}</p>

      <div class="task__options">
        <button class="task__status ${status.toLowerCase()} select_tas" data-task-status="${status}">
          ${listStatus[status]}
        </button>

        <button class="task__delete delete_task" data-id-task="${id}">
          Eliminar
        </button>
      </div>
    `;

    list.appendChild(taskElement);
  });
};
