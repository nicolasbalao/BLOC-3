<section class="task_section">
    <h1 class="title">Tasks</h1>
    <div class="task_container" id="task_container">
        <?php foreach ($tasks as $task) : ?>
            <div class="task done">
                <div>
                    <div class="hidden" id="task_id"><?= $task->id ?></div>
                    <p class="task__name" contenteditable><?= $task->name ?></p>
                </div>
                <div class="right_content">

                    <div class="task__done">
                        <input type="checkbox" <?php echo isset($task->done) && $task->done ? 'checked' : ''; ?>>

                    </div>
                    <div class="task_delete">
                        <span class="material-symbols-outlined">
                            delete
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>
    <button class="button-add" id="button-add">Create</button>
</section>