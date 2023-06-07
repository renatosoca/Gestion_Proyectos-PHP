import taskStore from "../../../store/taskStore";
import { deleteTaskById } from "../../useCases/deleteTaskById";
import { getTaskById } from "../../useCases/getTaskById";
import { saveTask } from "../../useCases/saveTask";
import { showModal } from "../modals/renderModal";

let list;
const listStatus = {
  pending: "Pendiente",
  completed: "Completado",
};

const createListTasks = () => {
  const listTasks = document.createElement("ul");
  listTasks.classList.add("tasks__list");

  return listTasks;
};

const taskSelected = async (e) => {
  const btnEdit = e.target.closest(".select_task");
  if (!btnEdit) return;

  const idTask = btnEdit.dataset.idTask;

  showModal(idTask);
};

const taskStatus = async (e, projectId) => {
  const btnStatus = e.target.closest(".select_status");
  if (!btnStatus) return;

  const idTask = btnStatus.dataset.id;
  const status = btnStatus.dataset.taskStatus;

  try {
    const task = await getTaskById(idTask);
    const newTask = {
      ...task,
      status: status === "pending" ? "completed" : "pending",
    };
    const resp = await saveTask(newTask);
    console.log(resp);
    await taskStore.reloadPage(projectId);

    renderTasks();
  } catch (error) {
    console.log(error);
  }
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
    list.addEventListener("click", (event) => taskStatus(event, projectId));
    list.addEventListener("click", (event) => deleteTask(event, projectId));
  }

  while (list.firstChild) {
    list.removeChild(list.firstChild);
  }

  if (tasks.length === 0) {
    const taskElement = document.createElement("li");
    taskElement.textContent = "No hay tareas";
    taskElement.classList.add("tasks__empty");
    list.appendChild(taskElement);
    return;
  }

  tasks.forEach((task) => {
    const { id, name, status } = task;

    const taskElement = document.createElement("li");
    taskElement.classList.add("tasks__item");
    taskElement.dataset.idTask = id;
    taskElement.innerHTML = `
      <p class="tasks__name select_task" data-id-task="${id}">${name}</p>

      <div class="tasks__options">
        <button class="tasks__status ${status.toLowerCase()} select_status" data-task-status="${status}" data-id="${id}" >
          ${listStatus[status]}
        </button>

        <button class="tasks__delete delete_task" data-id-task="${id}">
          Eliminar
        </button>
      </div>
    `;

    list.appendChild(taskElement);
  });
};
