import taskStore, { Filters } from "../store/taskStore";
import { renderAddBtnTask } from "./renders/buttons/renderAddBtn";
import { renderModal } from "./renders/modals/renderModal";
import { renderTasks } from "./renders/tasks/renderTasks";
import { saveTask } from "./useCases/saveTask";

const pageProject = document.querySelector("#page-project");

const layout = document.querySelector("#dashboard");
const element = document.querySelector("#list-tasks");
const filtersTasks = document.querySelectorAll(
  '#filters button[type="button"]'
);

const projectId = window.location.href.split("/")[4];

export const taskApp = async () => {
  if (!pageProject) return;

  element.innerHTML = `
    <div class="loading">
      <span class="loading__title" >Cargando</span>
      <div class="loading__spinner"></div>
    </div>   
  `;

  await taskStore.loadTask(projectId);

  while (element.firstChild) {
    element.removeChild(element.firstChild);
  }

  renderTasks(element, projectId);

  renderAddBtnTask();
  renderModal(layout, async (taskObject) => {
    const newTaskObject = {
      ...taskObject,
      projectId: taskObject.projectId ? taskObject.projectId : projectId,
    };
    const task = await saveTask(newTaskObject);
    taskStore.onChangeTask(task);

    renderTasks();
  });

  filtersTasks.forEach((filter) => {
    filter.addEventListener("click", () => {
      filtersTasks.forEach((filter) =>
        filter.classList.remove("filters__btn--active")
      );
      const status = filter.id;
      filter.classList.add("filters__btn--active");

      switch (status) {
        case "all":
          taskStore.setFilter(Filters.all);
          break;

        case "pending":
          taskStore.setFilter(Filters.pending);
          break;

        case "completed":
          taskStore.setFilter(Filters.completed);
          break;

        default:
          break;
      }
      taskStore.setFilter(status);
      renderTasks();
    });
  });
};
taskApp();
