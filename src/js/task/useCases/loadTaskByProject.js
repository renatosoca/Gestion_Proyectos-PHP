import { endPointTaskToModel } from "../mappers/endpointTaskMapper";

export const loadTaskByProject = async (projectId, page = 1) => {
  const url = `http://localhost:3000/api/v1/tasks/${projectId}?page=${page}`;
  try {
    const response = await fetch(url);
    const result = await response.json();
    const tasks = result.map(endPointTaskToModel);

    return tasks;
  } catch (error) {
    console.log(error);
  }
};
