import { showModal } from "../renderModal/renderModal";

export const renderAddBtnTask = () => {
  const btn = document.querySelector("#new-task");

  btn.addEventListener("click", () => {
    showModal();
  });
};
