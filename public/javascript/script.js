// ------------------------------Home Page---------------------

// VARIABLE
const addTaskButton = document.getElementById("button-add");
const taskContainer = document.getElementById("task_container");

const tasksName = Array.from(document.getElementsByClassName("task__name"));

// EVENT
addTaskButton.addEventListener("click", (e) => {
  const newTask = createTaskElement();
  taskContainer.appendChild(newTask);

  // Set focus on the contenteditable label
  const contentEditableLabel = newTask.querySelector(".task__name");
  if (contentEditableLabel) {
    contentEditableLabel.focus();
  }

  handleTasksChange();
});

// FUNCTION

const createTaskElement = () => {
  const newTask = document.createElement("div");
  newTask.innerHTML = `
            <div class="task">
                <div>
                <div class="hidden"></div>
                <p class="task__name" contenteditable id="task_id">New task</p>
            </div>
                <div class="right_content">

                    <div class="task__done">
                        <input type="checkbox" value="<?= $task->done ?>">

                    </div>
                    <div class="task_delete">
                        <span class="material-symbols-outlined">
                            delete
                        </span>
                    </div>
                </div>
            </div>
        `;

  return newTask;
};

const handleTasksChange = () => {
  const tasks = Array.from(document.getElementsByClassName("task"));

  tasks.forEach((task) => {
    // TODO: refactor this ugly selection
    const taskId = task.children[0].children[0];
    const taskName = task.children[0].children[1];
    const taskDone = task.children[1].children[0].children[0];
    const deleteButton = task.children[1].children[1].children[0];

    console.log("delete button", deleteButton);

    taskName.addEventListener("blur", () => {
      let payload = {
        id: taskId.textContent.trim() !== "" ? taskId.textContent.trim() : null,
        name: taskName.textContent.trim(),
      };
      handleSavingTask(payload);
    });

    taskDone.addEventListener("change", () => {
      let payload = {
        id: taskId.textContent.trim() !== "" ? taskId.textContent.trim() : null,
        name: taskName.textContent.trim(),
        done: taskDone.checked,
      };
      console.log(payload);
      handleSavingTask(payload);
    });

    deleteButton.addEventListener("click", () => {
      const id =
        taskId.textContent.trim() !== "" ? taskId.textContent.trim() : null;
      deleteTask(id);
    });
  });
};

const handleSavingTask = (task) => {
  if (!task.id) {
    console.log("create");
    createTask(task);
  } else {
    console.log("update");
    updateTask(task);
  }
};
const createTask = async (task) => {
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(task),
  };

  const rep = await fetch("/", options);

  console.log(rep);
};
const updateTask = async (task) => {
  console.log(task);
  const options = {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(task),
  };

  const rep = await fetch(`/${task.id}`, options);

  console.log(rep);
};

const deleteTask = async (taskId) => {
  const options = {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
  };

  const rep = await fetch(`/${taskId}`, options);
};

handleTasksChange();
