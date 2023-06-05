import { loadTaskByProject } from "../task/useCases/loadTaskByProject";

export const Filters = {
  all: "all",
  completed: "completed",
  pending: "pending",
};

const state = {
  tasks: [],
  currentPage: 0,
  filter: Filters.all,
};

const loadTask = async (projectId) => {
  const tasks = await loadTaskByProject(projectId);

  state.tasks = tasks;
  state.filter = Filters.all;
};

const getTasks = (filter = Filters.all) => {
  switch (filter) {
    case Filters.all:
      return [...state.tasks];

    case Filters.completed:
      return state.tasks.filter((task) => task.status === "completed");

    case Filters.pending:
      return state.tasks.filter((task) => task.status === "pending");

    default:
      throw new Error(`Filter ${filter} not found`);
  }
};

const loadNextPage = async (projectId) => {
  const tasks = await loadTaskByProject(projectId, state.currentPage + 1);
  if (tasks.length === 0) return;

  state.currentPage++;
  state.tasks = tasks;
};

const loadPreviusPage = async (projectId) => {
  if (state.currentPage <= 1) return;

  const tasks = await loadTaskByProject(projectId, state.currentPage - 1);

  state.currentPage--;
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

  if (!wasFound) {
    state.tasks.push(taskUpdated);
  }
};

const setFilter = (newFilter) => {
  state.filter = newFilter;
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
  loadTask,
  getTasks,
  loadNextPage,
  loadPreviusPage,
  reloadPage,
  onChangeTask,
  setFilter,

  getCurrentPage: () => state.currentPage,
  getCurrentFilter: () => state.filter,
};
