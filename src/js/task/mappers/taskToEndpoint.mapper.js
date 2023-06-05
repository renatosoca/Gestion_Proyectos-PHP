export const taskModelToEndPoint = (taskObject) => {
  const { id, name, projectId, status } = taskObject;

  return {
    id,
    name,
    project_id: projectId,
    status,
  };
};
