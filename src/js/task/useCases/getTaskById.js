import { endPointTaskToModel } from "../mappers/endpointTaskMapper";

export const getTaskById = async (id) => {
  const url = `http://localhost:3000/api/v1/task/get/${id}`;
  try {
    const response = await fetch(url);
    const result = await response.json();
    const task = endPointTaskToModel(result);

    return task;
  } catch (error) {
    console.log(error);
  }
};
