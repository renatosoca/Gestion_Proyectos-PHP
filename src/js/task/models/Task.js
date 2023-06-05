export class Task {
  constructor({ id = "", name, projectId, status = "pending" }) {
    this.id = id;
    this.name = name;
    this.projectId = projectId;
    this.status = status;
  }
}
