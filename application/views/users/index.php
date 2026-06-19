<!-- Created by Hanif -->
<div style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            <h2 style="color: #fff; margin-top: 0; font-weight: 600; font-size: 24px;">
                <i class="fas fa-users" style="color: var(--accent); margin-right: 10px;"></i>
                User Management
            </h2>
            <p style="color: var(--text-muted); line-height: 1.6; max-width: 800px; margin-bottom: 0;">
                Manage administrators and users for this dashboard.
            </p>
        </div>
        <div>
            <button class="btn btn-outline" style="border: 1px solid var(--accent); background: var(--accent); color: #000; padding: 8px 15px; border-radius: 6px; font-weight: bold;" onclick="openModal()">
                <i class="fas fa-plus"></i> Add User
            </button>
        </div>
    </div>

    <div class="user-card">
        <table style="width: 100%; border-collapse: collapse; color: #fff;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left;">
                    <th style="padding: 15px;">ID</th>
                    <th style="padding: 15px;">Username</th>
                    <th style="padding: 15px;">Role</th>
                    <th style="padding: 15px;">Created At</th>
                    <th style="padding: 15px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 15px;"><?= $user['id'] ?></td>
                    <td style="padding: 15px; font-weight: bold;"><?= htmlspecialchars($user['username']) ?></td>
                    <td style="padding: 15px;">
                        <?php if($user['role'] == 'admin'): ?>
                            <span class="badge badge-admin">Admin</span>
                        <?php else: ?>
                            <span class="badge badge-user">User</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px; color: var(--text-muted); font-size: 13px;"><?= $user['created_at'] ?></td>
                    <td style="padding: 15px; text-align: right;">
                        <button class="btn-text-accent" onclick='openModal(<?= $user["id"] ?>, "<?= htmlspecialchars($user["username"]) ?>", "<?= $user["role"] ?>")'><i class="fas fa-edit"></i></button>
                        <?php if($user['username'] !== $this->session->userdata('username') && $user['username'] !== 'admin'): ?>
                        <button class="btn-text-danger" style="margin-left: 10px;" onclick="deleteUser(<?= $user['id'] ?>)"><i class="fas fa-trash"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="userModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#1b2a47; width:400px; max-width:90%; border-radius:12px; border:1px solid rgba(255,255,255,0.1); box-shadow:0 10px 40px rgba(0,0,0,0.5);">
        <div style="padding:20px; border-bottom:1px solid rgba(255,255,255,0.1); display:flex; justify-content:space-between;">
            <h3 style="margin:0; color:#fff;" id="modalTitle">Add User</h3>
            <i class="fas fa-times close-modal" onclick="closeModal()" style="cursor:pointer; color:#aaa;"></i>
        </div>
        <div style="padding:20px;">
            <input type="hidden" id="form_id">
            <div style="margin-bottom: 15px;">
                <label style="display:block; color:var(--text-muted); font-size:12px; margin-bottom:5px;">Username</label>
                <input type="text" class="form-control" id="form_username" placeholder="Username">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display:block; color:var(--text-muted); font-size:12px; margin-bottom:5px;">Password</label>
                <input type="password" class="form-control" id="form_password" placeholder="Leave blank to keep unchanged">
                <small style="color:var(--text-muted); font-size:11px;" id="pwd_hint">Leave blank to keep current password.</small>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display:block; color:var(--text-muted); font-size:12px; margin-bottom:5px;">Role</label>
                <select class="form-control" id="form_role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <div style="padding:20px; border-top:1px solid rgba(255,255,255,0.1); text-align:right;">
            <button class="btn btn-outline" style="margin-right:10px; color:#aaa; border:none; background:transparent;" onclick="closeModal()">Cancel</button>
            <button class="btn" style="background:var(--accent); color:#000; border:none; padding:8px 20px; border-radius:4px; font-weight:bold; cursor:pointer;" onclick="saveUser()">Save</button>
        </div>
    </div>
</div>

<style>
    .user-card { background: #1b2a47; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); overflow-x: auto; }
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge-admin { background: rgba(229, 169, 60, 0.2); color: var(--accent); border: 1px solid rgba(229, 169, 60, 0.3); }
    .badge-user { background: rgba(0, 255, 209, 0.1); color: #00ffd1; border: 1px solid rgba(0, 255, 209, 0.2); }
    
    .btn-text-accent { background: transparent; border: none; color: var(--accent); cursor: pointer; font-size: 15px; transition: 0.2s;}
    .btn-text-accent:hover { color: #fff; }
    .btn-text-danger { background: transparent; border: none; color: #ff4d4d; cursor: pointer; font-size: 15px; transition: 0.2s;}
    .btn-text-danger:hover { color: #fff; }
    
    .form-control { width: 100%; box-sizing: border-box; background: #111a2f; border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 10px; border-radius: 4px; font-family: 'Inter', sans-serif;}
    .form-control:focus { outline: none; border-color: var(--accent); }
    select.form-control { appearance: none; }
</style>

<script>
    function openModal(id = '', username = '', role = 'user') {
        document.getElementById('form_id').value = id;
        document.getElementById('form_username').value = username;
        document.getElementById('form_role').value = role;
        document.getElementById('form_password').value = '';
        
        if(id) {
            document.getElementById('modalTitle').innerText = 'Edit User';
            document.getElementById('pwd_hint').style.display = 'block';
        } else {
            document.getElementById('modalTitle').innerText = 'Add User';
            document.getElementById('pwd_hint').style.display = 'none';
        }
        
        document.getElementById('userModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('userModal').style.display = 'none';
    }

    function saveUser() {
        let formData = new FormData();
        formData.append('id', document.getElementById('form_id').value);
        formData.append('username', document.getElementById('form_username').value);
        formData.append('password', document.getElementById('form_password').value);
        formData.append('role', document.getElementById('form_role').value);

        fetch('<?= site_url("users/save") ?>', {
            method: 'POST',
            body: formData
        }).then(r=>r.json()).then(res=>{
            if(res.status == 'success') {
                window.location.reload();
            } else {
                alert(res.message || 'Error saving user');
            }
        });
    }

    function deleteUser(id) {
        if(confirm('Are you sure you want to delete this user?')) {
            let formData = new FormData();
            formData.append('id', id);
            fetch('<?= site_url("users/delete") ?>', {
                method: 'POST',
                body: formData
            }).then(r=>r.json()).then(res=>{
                if(res.status == 'success') {
                    window.location.reload();
                } else {
                    alert(res.message || 'Error deleting user');
                }
            });
        }
    }
</script>
