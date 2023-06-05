import { Task } from "../models/Task";

export const endPointTaskToModel = (endPointTask) => {
  const { id, name, project_id, status } = endPointTask;

  return new Task({
    id,
    name,
    projectId: project_id,
    status,
  });
};
