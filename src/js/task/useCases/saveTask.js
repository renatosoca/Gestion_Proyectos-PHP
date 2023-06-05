import { endPointTaskToModel } from "../mappers/endpointTaskMapper";
import { taskModelToEndPoint } from "../mappers/taskToEndpoint.mapper";
import { Task } from "../models/Task";

export const saveTask = async (taskObject) => {
  let taskUpdated;

  const task = new Task(taskObject);

  const taskToSave = taskModelToEndPoint(task);

  const formData = new FormData();
  for (const [key, value] of Object.entries(taskToSave)) {
    formData.append(`${key}`, value);
  }

  if (task.id) {
    taskUpdated = await updateTask(formData, task.id);
  } else {
    taskUpdated = await createTask(formData);
  }

  return endPointTaskToModel(taskUpdated);
};

const createTask = async (formData) => {
  const url = `http://localhost:3000/api/v1/task/create`;

  try {
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });
    const result = await response.json();

    return result;
  } catch (error) {
    console.log(error);
  }
};

const updateTask = async (formData, id) => {
  const url = `http://localhost:3000/api/v1/task/update/${id}`;

  try {
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });

    const result = await response.json();
    return result;
  } catch (error) {
    console.log(error);
  }
};
