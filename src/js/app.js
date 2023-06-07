import "./task/taskApp";

const btnSidebar = document.querySelector("#btn-sidebar");
btnSidebar.addEventListener("click", () => {
  const sidebar = document.querySelector("#sidebar");
  sidebar.classList.toggle("sidebar--active");
});
