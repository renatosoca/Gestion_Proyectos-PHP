import { loadTaskByProject } from "../useCases/loadTaskByProject";

const state = {
  tasks: [],
  selectedTask: null,
};

const reloadPage = async (projectId) => {
  const tasks = await loadTaskByProject(projectId);

  state.tasks = tasks;
};

export default {
  reloadPage,
  getTasks: () => [...state.tasks],
};
