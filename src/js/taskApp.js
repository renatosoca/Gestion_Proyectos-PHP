import { renderAddBtnTask } from "./presentations/renderAddBtnTask/renderAddBtn";
import { renderModal } from "./presentations/renderModal/renderModal";
import { renderTasks } from "./presentations/renderTasks/renderTasks";
import taskStore from "./store/taskStore";
import { loadTaskByProject } from "./useCases/loadTaskByProject";
import { saveTask } from "./useCases/saveTask";

const layout = document.querySelector("#dashboard");
const projectId = window.location.href.split("/")[4];

/* loadTaskByProject(projectId); */

export const taskApp = async (element) => {
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
      projectId,
      status: "pending",
    };
    const task = await saveTask(newTaskObject);
    console.log(task);
  });

  return;
};
