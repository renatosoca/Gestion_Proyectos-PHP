import { loadTaskByProject } from "../useCases/loadTaskByProject";

const state = {
  tasks: [],
  currentTask: 0,
};

const getTasks = () => {
  return state.tasks;
};

const loadNextPage = async (projectId) => {
  const tasks = await loadTaskByProject(projectId, state.currentTask + 1);
  if (tasks.length === 0) return;

  state.currentTask++;
  state.tasks = tasks;
};

const loadPreviusPage = async (projectId) => {
  if (state.currentTask <= 1) return;

  const tasks = await loadTaskByProject(projectId, state.currentTask - 1);

  state.currentTask--;
  state.tasks = tasks;
};

const onChangeTask = async (taskUpdated) => {
  let wasFound = false;

  state.tasks = state.tasks.map((task) => {
    if (task.id === taskUpdated.id) {
      wasFound = true;
      return taskUpdated;
    }

    return task;
  });

  // Si no se encontró la tarea, se agrega
  if (!wasFound) {
    state.tasks.push(taskUpdated);
  }
};

const setFilter = (status) => {
  state.filter = status;
};

const reloadPage = async (projectId) => {
  const tasks = await loadTaskByProject(projectId);
  if (tasks.length === 0) {
    await loadPreviusPage(projectId);
    return;
  }

  state.tasks = tasks;
};

export default {
  loadNextPage,
  loadPreviusPage,
  reloadPage,
  onChangeTask,

  getTasks: () => [...state.tasks],
  getCurrentPage: () => state.currentTask,
};
