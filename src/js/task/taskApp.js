import { renderAddBtnTask } from "./presentations/renderAddBtnTask/renderAddBtn";
import { renderModal } from "./presentations/renderModal/renderModal";
import { renderTasks } from "./presentations/renderTasks/renderTasks";
import taskStore from "./store/taskStore";
import { saveTask } from "./useCases/saveTask";

const layout = document.querySelector("#dashboard");
const element = document.querySelector("#listado-tareas");

const projectId = window.location.href.split("/")[4];

export const taskApp = async () => {
  element.innerHTML = `
    <div class="loading">
      <span class="loading__title" >Cargando</span>
      <div class="loading__spinner"></div>
    </div>   
  `;

  await taskStore.reloadPage(projectId);

  while (element.firstChild) {
    element.removeChild(element.firstChild);
  }

  renderTasks(element);

  renderAddBtnTask();
  renderModal(layout, async (taskObject) => {
    const newTaskObject = {
      ...taskObject,
      id: "",
      projectId,
      status: "pending",
    };
    const task = await saveTask(newTaskObject);
    console.log(task);
  });
};
