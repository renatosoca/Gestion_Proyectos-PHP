import { endPointTaskToModel } from "../mappers/endpointTaskMapper";
import { taskModelToEndPoint } from "../mappers/taskToEndpoint.mapper";
import { Task } from "../models/Task";

export const saveTask = async (taskObject) => {
  let taskUpdated;

  const task = new Task(taskObject);

  const taskToSave = taskModelToEndPoint(task);

  if (task.id) {
    taskUpdated = await updateTask(taskToSave);
  } else {
    taskUpdated = await createTask(taskToSave);
  }
  console.log(taskUpdated);

  return endPointTaskToModel(taskUpdated);
};

const createTask = async (task) => {
  const url = `http://localhost:3000/api/v1/task/create`;

  const formData = new FormData();
  formData.append("project_id", task.project_id);
  try {
    console.log(task);
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });
    const result = await response.json();
    console.log(result);

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
      body: JSON.stringify(task),
    });

    return await response.json();
  } catch (error) {
    console.log(error);
  }
};
