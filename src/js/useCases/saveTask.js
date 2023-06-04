import { endPointTaskToModel } from "../mappers/endpointTaskMapper";
import { taskModelToEndPoint } from "../mappers/taskToEndpoint.mapper";
import { Task } from "../models/Task";

export const saveTask = async (taskObject) => {
  let taskUpdated;

  const task = new Task(taskObject);

  const taskToSave = taskModelToEndPoint(task);
  const taskArray = Object.entries(taskToSave);

  const formData = new FormData();
  for (const [key, value] of taskArray) {
    formData.append(`${key}`, value);
  }

  if (task.id) {
    taskUpdated = await updateTask(formData);
  } else {
    taskUpdated = await createTask(formData);
  }

  return endPointTaskToModel(taskUpdated);
};

const createTask = async (task) => {
  const url = `http://localhost:3000/api/v1/task/create`;

  try {
    const response = await fetch(url, {
      method: "POST",
      body: task,
    });
    const result = await response.json();

    return result;
  } catch (error) {
    console.log(error);
  }
};

const updateTask = async (task) => {
  const url = `http://localhost:3000/api/v1/task/${task.id}`;

  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: task,
    });

    return await response.json();
  } catch (error) {
    console.log(error);
  }
};
