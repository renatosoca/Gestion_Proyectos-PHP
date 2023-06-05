export const deleteTaskById = async (idTask, projectId) => {
  const formData = new FormData();
  formData.append("projectId", projectId);
  try {
    const url = `http://localhost:3000/api/v1/task/delete/${idTask}`;

    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });
    const data = await response.json();

    return data;
  } catch (error) {
    console.log(error);
  }
};
