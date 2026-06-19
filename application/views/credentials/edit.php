<!-- Created by Hanif -->
<style>
    .form-container {
        background-color: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 8px;
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5);
    }
    
    .page-title {
        font-family: 'Consolas', monospace;
        color: var(--accent);
        font-size: 24px;
        margin-top: 0;
        margin-bottom: 30px;
        text-shadow: 0 0 5px rgba(0, 255, 209, 0.3);
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 15px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
    }
    
    .form-col {
        flex: 1;
    }
    
    label {
        display: block;
        margin-bottom: 8px;
        color: #888;
        font-size: 12px;
        text-transform: uppercase;
        font-family: 'Consolas', monospace;
    }
    
    .required {
        color: #ff4d4d;
    }
    
    .form-control {
        width: 100%;
        padding: 12px;
        background-color: rgba(0,0,0,0.3);
        border: 1px solid #333;
        border-radius: 4px;
        color: var(--text-color);
        font-family: 'Consolas', monospace;
        box-sizing: border-box;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 8px rgba(0, 255, 209, 0.2);
    }
    
    select.form-control option {
        background-color: #0A0E1A;
        color: #C9D6E3;
    }
    
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
        font-family: 'Inter', sans-serif;
    }
    
    .form-actions {
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(255,255,255,0.05);
        padding-top: 20px;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
    }
    
    .error-text {
        color: #ff4d4d;
        font-size: 12px;
        margin-top: 5px;
    }
    
    .last-updated {
        font-size: 11px;
        color: #666;
        font-family: 'Consolas', monospace;
    }
</style>

<div class="form-container">
    <h2 class="page-title">EDIT CREDENTIAL</h2>
    
    <form action="<?= site_url('credentials/update/'.$credential['id']) ?>" method="POST">
        <div class="form-row">
            <div class="form-group form-col">
                <label>Category <span class="required">*</span></label>
                <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="VM" <?= set_select('category', 'VM', $credential['category'] == 'VM') ?>>Virtual Machine (VM)</option>
                    <option value="Database" <?= set_select('category', 'Database', $credential['category'] == 'Database') ?>>Database</option>
                    <option value="SSH" <?= set_select('category', 'SSH', $credential['category'] == 'SSH') ?>>SSH Key</option>
                    <option value="API Key" <?= set_select('category', 'API Key', $credential['category'] == 'API Key') ?>>API Key</option>
                    <option value="Web App" <?= set_select('category', 'Web App', $credential['category'] == 'Web App') ?>>Web App</option>
                    <option value="Other" <?= set_select('category', 'Other', $credential['category'] == 'Other') ?>>Other</option>
                </select>
                <?= form_error('category', '<div class="error-text">', '</div>') ?>
            </div>
            
            <div class="form-group form-col">
                <label>Label <span class="required">*</span></label>
                <input type="text" name="label" class="form-control" value="<?= set_value('label', $credential['label']) ?>" required>
                <?= form_error('label', '<div class="error-text">', '</div>') ?>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group form-col" style="flex: 3;">
                <label>Host / URL / IP</label>
                <input type="text" name="host" class="form-control" value="<?= set_value('host', $credential['host']) ?>">
            </div>
            
            <div class="form-group form-col" style="flex: 1;">
                <label>Port</label>
                <input type="text" name="port" class="form-control" value="<?= set_value('port', $credential['port']) ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group form-col">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= set_value('username', $credential['username']) ?>">
            </div>
            
            <div class="form-group form-col">
                <label>Password</label>
                <input type="text" name="password" class="form-control" value="<?= set_value('password', $credential['password']) ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label>Notes / Additional Details</label>
            <textarea name="notes" class="form-control"><?= set_value('notes', $credential['notes']) ?></textarea>
        </div>
        
        <div class="form-actions">
            <div class="last-updated">
                Last updated: <?= date('Y-m-d H:i', strtotime($credential['updated_at'])) ?>
            </div>
            <div class="action-buttons">
                <a href="<?= site_url('credentials') ?>" class="btn" style="border-color: #666; color: #ccc;">Cancel</a>
                <button type="submit" class="btn" style="background-color: rgba(0, 255, 209, 0.1);">Update</button>
            </div>
        </div>
    </form>
</div>
