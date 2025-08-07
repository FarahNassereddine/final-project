const addTaskBtn = document.getElementById("add-task");
const taskList = document.getElementById("task-list");
const newTaskInput = document.getElementById("new-task");
const toggleThemeBtn = document.getElementById("toggle-theme");

addTaskBtn.addEventListener("click", () => {
  const taskText = newTaskInput.value.trim();
  if (taskText !== "") {
    createTaskItem(taskText);
    newTaskInput.value = "";
  }
});

function createTaskItem(text) {
  const li = document.createElement("li");
  li.className = "task-item";

  const span = document.createElement("span");
  span.textContent = text;

  const actions = document.createElement("div");
  actions.className = "task-actions";

  const completeBtn = document.createElement("button");
  completeBtn.textContent = "✔️";
  completeBtn.title = "Mark as complete";
  completeBtn.onclick = () => {
    li.classList.toggle("completed");
  };

  const editBtn = document.createElement("button");
  editBtn.textContent = "✏️";
  editBtn.title = "Edit task";
  editBtn.onclick = () => {
    const newText = prompt("Edit task:", span.textContent);
    if (newText !== null && newText.trim() !== "") {
      span.textContent = newText.trim();
    }
  };

  const deleteBtn = document.createElement("button");
  deleteBtn.textContent = "🗑️";
  deleteBtn.title = "Delete task";
  deleteBtn.onclick = () => {
    taskList.removeChild(li);
  };

  actions.appendChild(completeBtn);
  actions.appendChild(editBtn);
  actions.appendChild(deleteBtn);

  li.appendChild(span);
  li.appendChild(actions);
  taskList.appendChild(li);
}

toggleThemeBtn.addEventListener("click", () => {
  const isDark = document.body.classList.toggle("dark-mode");

  // Update icon and title
  toggleThemeBtn.textContent = isDark ? "☀️" : "🌙";
  toggleThemeBtn.title = isDark ? "Switch to Light Mode" : "Switch to Dark Mode";
});
