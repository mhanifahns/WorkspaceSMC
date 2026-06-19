<style>
    .kanban-board {
        display: flex;
        gap: 20px;
        height: calc(100vh - 200px);
        overflow-x: auto;
        padding-bottom: 20px;
    }
    
    .kanban-column {
        flex: 1;
        min-width: 300px;
        background-color: rgba(0,0,0,0.3);
        border: 1px solid var(--card-border);
        border-radius: 8px;
        display: flex;
        flex-direction: column;
    }
    
    .column-header {
        padding: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        font-family: 'Consolas', monospace;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .task-list {
        flex-grow: 1;
        padding: 15px;
        overflow-y: auto;
        min-height: 150px;
    }
    
    .task-card {
        background-color: var(--card-bg);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: grab;
        transition: all 0.2s;
    }
    
    .task-card:active {
        cursor: grabbing;
    }
    
    .task-card:hover {
        border-color: var(--accent);
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        transform: translateY(-2px);
    }
    
    .task-title {
        font-weight: 600;
        margin-bottom: 8px;
        color: #fff;
    }
    
    .task-desc {
        font-size: 13px;
        color: #aaa;
        line-height: 1.4;
        margin-bottom: 10px;
    }
    
    .task-meta {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: #666;
        font-family: 'Consolas', monospace;
        align-items: center;
    }

    .delete-task, .edit-task {
        text-decoration: none;
        opacity: 0;
        transition: opacity 0.2s;
    }
    
    .delete-task {
        color: #ff4d4d;
    }
    
    .edit-task {
        color: #00B8D9;
        margin-right: 10px;
    }

    .task-card:hover .delete-task,
    .task-card:hover .edit-task {
        opacity: 1;
    }

    .sortable-ghost {
        opacity: 0.4;
        background-color: rgba(0, 255, 209, 0.1);
    }
    
    .add-task-btn {
        width: 100%;
        padding: 10px;
        background: transparent;
        border: 1px dashed rgba(255,255,255,0.2);
        color: #888;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }
    
    .add-task-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: rgba(0, 255, 209, 0.05);
    }

    .project-selector {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }
    .project-tabs {
        display: flex;
        gap: 10px;
        overflow-x: auto;
    }
    .project-tab {
        padding: 8px 15px;
        background: rgba(0,0,0,0.5);
        border: 1px solid var(--card-border);
        color: #888;
        border-radius: 4px;
        text-decoration: none;
        font-family: 'Consolas', monospace;
        font-size: 13px;
        white-space: nowrap;
    }
    .project-tab.active {
        background: rgba(0,255,209,0.1);
        color: var(--accent);
        border-color: var(--accent);
    }
    .project-tab:hover:not(.active) {
        color: #fff;
        border-color: #fff;
    }
</style>

<?php if($this->session->flashdata('error')): ?>
    <div class="alert" style="background-color: rgba(244,67,54,0.1); border: 1px solid #F44336; color: #F44336;">
        <i class="fas fa-exclamation-triangle"></i> <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px;">
    <h1 class="page-title anim-slide-left">
        <i class="fas fa-columns"></i> Kanban Board
    </h1>
    <div style="display:flex; gap: 10px;">
        <button class="btn" style="border-color: #FFD700; color: #FFD700;" onclick="openColModal()"><i class="fas fa-plus"></i> Add Category</button>
        <button class="btn" onclick="openProjModal()"><i class="fas fa-folder-plus"></i> New Project</button>
    </div>
</div>

<div class="project-selector anim-slide-left">
    <span style="font-family: 'Consolas', monospace; font-size: 12px; color: #888;">PROJECT:</span>
    <div class="project-tabs">
        <?php foreach($projects as $p): ?>
            <a href="<?= site_url('tasks?project='.$p['id']) ?>" class="project-tab <?= $active_project_id == $p['id'] ? 'active' : '' ?>">
                <?= htmlspecialchars($p['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="kanban-board anim-fade-up">
    <?php foreach($columns as $col): ?>
        <div class="kanban-column">
            <div class="column-header" style="color: <?= $col['color'] ?>; border-top: 3px solid <?= $col['color'] ?>;">
                <span><?= htmlspecialchars($col['name']) ?></span>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span class="badge" style="background: <?= $col['color'] ?>20; color: <?= $col['color'] ?>; padding: 2px 8px; border-radius: 10px; font-size:12px;"><?= count($tasks_by_column[$col['id']]) ?></span>
                    <a href="<?= site_url('tasks/delete_column/'.$col['id'].'?project='.$active_project_id) ?>" onclick="return confirm('Remove this category?');" style="color: #666; font-size: 12px;" title="Delete Category"><i class="fas fa-times"></i></a>
                </div>
            </div>
            <div class="task-list" data-column="<?= $col['id'] ?>">
                <?php foreach($tasks_by_column[$col['id']] as $task): ?>
                    <div class="task-card" data-id="<?= $task['id'] ?>">
                        <div class="task-title"><?= htmlspecialchars($task['title']) ?></div>
                        <?php if(!empty($task['description'])): ?>
                            <div class="task-desc"><?= nl2br(htmlspecialchars($task['description'])) ?></div>
                        <?php endif; ?>
                        <div class="task-meta">
                            <span><i class="far fa-clock"></i> <?= date('M d', strtotime($task['created_at'])) ?></span>
                            <div>
                                <a href="javascript:void(0)" class="edit-task" onclick="openEditTaskModal(this)" data-id="<?= $task['id'] ?>" data-title="<?= htmlspecialchars($task['title'], ENT_QUOTES) ?>" data-desc="<?= htmlspecialchars($task['description'], ENT_QUOTES) ?>" title="Edit Task"><i class="fas fa-edit"></i></a>
                                <a href="<?= site_url('tasks/delete/'.$task['id'].'?project='.$active_project_id) ?>" class="delete-task" onclick="return confirm('Delete this task?');" title="Delete Task"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="padding: 0 15px 15px;">
                <button class="add-task-btn" onclick="openTaskModal(<?= $col['id'] ?>)"><i class="fas fa-plus"></i> Add a card</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Task Modal -->
<div class="modal" id="taskModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 style="margin:0;">Create Task</h3>
            <i class="fas fa-times close-modal" onclick="closeTaskModal()"></i>
        </div>
        <div class="modal-body">
            <form id="taskForm">
                <input type="hidden" id="taskColId" value="">
                <input type="hidden" id="taskProjId" value="<?= $active_project_id ?>">
                <div class="form-group">
                    <label>Task Title *</label>
                    <input type="text" id="taskTitle" class="form-control" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="taskDesc" class="form-control" rows="4"></textarea>
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" style="border-color: #888; color: #888;" onclick="closeTaskModal()">Cancel</button>
                    <button type="submit" class="btn">Save Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal" id="editTaskModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 style="margin:0;">Edit Task</h3>
            <i class="fas fa-times close-modal" onclick="closeEditTaskModal()"></i>
        </div>
        <div class="modal-body">
            <form id="editTaskForm">
                <input type="hidden" id="editTaskId" value="">
                <div class="form-group">
                    <label>Task Title *</label>
                    <input type="text" id="editTaskTitle" class="form-control" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="editTaskDesc" class="form-control" rows="4"></textarea>
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" style="border-color: #888; color: #888;" onclick="closeEditTaskModal()">Cancel</button>
                    <button type="submit" class="btn">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Project Modal -->
<div class="modal" id="projModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 style="margin:0;">New Project</h3>
            <i class="fas fa-times close-modal" onclick="closeProjModal()"></i>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('tasks/create_project') ?>" method="POST">
                <div class="form-group">
                    <label>Project Name *</label>
                    <input type="text" name="name" class="form-control" required autocomplete="off">
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" style="border-color: #888; color: #888;" onclick="closeProjModal()">Cancel</button>
                    <button type="submit" class="btn">Create Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal" id="colModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 style="margin:0;">New Category</h3>
            <i class="fas fa-times close-modal" onclick="closeColModal()"></i>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('tasks/create_column') ?>" method="POST">
                <input type="hidden" name="project_id" value="<?= $active_project_id ?>">
                <div class="form-group">
                    <label>Category Name *</label>
                    <input type="text" name="name" class="form-control" required autocomplete="off" placeholder="e.g. TESTING">
                </div>
                <div class="form-group">
                    <label>Highlight Color</label>
                    <input type="color" name="color" value="#00FFD1" style="width: 100%; height: 40px; border: none; background: transparent; cursor: pointer;">
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" style="border-color: #888; color: #888;" onclick="closeColModal()">Cancel</button>
                    <button type="submit" class="btn">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const columns = document.querySelectorAll('.task-list');
        
        columns.forEach(el => {
            new Sortable(el, {
                group: 'kanban',
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function (evt) {
                    const itemEl = evt.item;
                    const taskId = itemEl.getAttribute('data-id');
                    const newColId = evt.to.getAttribute('data-column');
                    const oldColId = evt.from.getAttribute('data-column');
                    
                    if(newColId !== oldColId) {
                        const formData = new FormData();
                        formData.append('id', taskId);
                        formData.append('column_id', newColId);
                        
                        fetch('<?= site_url("tasks/update_status") ?>', {
                            method: 'POST',
                            body: formData
                        });
                    }
                }
            });
        });
        
        // Task Modal logic
        const form = document.getElementById('taskForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const colId = document.getElementById('taskColId').value;
            const projId = document.getElementById('taskProjId').value;
            const title = document.getElementById('taskTitle').value;
            const desc = document.getElementById('taskDesc').value;
            
            const formData = new FormData();
            formData.append('column_id', colId);
            formData.append('project_id', projId);
            formData.append('title', title);
            formData.append('description', desc);
            
            fetch('<?= site_url("tasks/create") ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.reload();
                }
            });
        });
        
        // Edit Task Modal logic
        const editForm = document.getElementById('editTaskForm');
        if(editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('editTaskId').value;
                const title = document.getElementById('editTaskTitle').value;
                const desc = document.getElementById('editTaskDesc').value;
                
                const formData = new FormData();
                formData.append('id', id);
                formData.append('title', title);
                formData.append('description', desc);
                
                fetch('<?= site_url("tasks/update") ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    }
                });
            });
        }
    });
    
    function openTaskModal(colId) {
        document.getElementById('taskColId').value = colId;
        document.getElementById('taskModal').style.display = 'flex';
        document.getElementById('taskTitle').focus();
    }
    function closeTaskModal() {
        document.getElementById('taskModal').style.display = 'none';
        document.getElementById('taskForm').reset();
    }

    function openEditTaskModal(btn) {
        document.getElementById('editTaskId').value = btn.getAttribute('data-id');
        document.getElementById('editTaskTitle').value = btn.getAttribute('data-title');
        document.getElementById('editTaskDesc').value = btn.getAttribute('data-desc');
        document.getElementById('editTaskModal').style.display = 'flex';
        document.getElementById('editTaskTitle').focus();
    }
    function closeEditTaskModal() {
        document.getElementById('editTaskModal').style.display = 'none';
        document.getElementById('editTaskForm').reset();
    }

    function openProjModal() {
        document.getElementById('projModal').style.display = 'flex';
    }
    function closeProjModal() {
        document.getElementById('projModal').style.display = 'none';
    }

    function openColModal() {
        document.getElementById('colModal').style.display = 'flex';
    }
    function closeColModal() {
        document.getElementById('colModal').style.display = 'none';
    }
</script>
