<!-- Created by Hanif -->
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .page-title {
        font-family: 'Consolas', monospace;
        color: var(--accent);
        font-size: 24px;
        margin: 0;
        text-shadow: 0 0 5px rgba(0, 255, 209, 0.3);
    }
    
    .search-bar {
        display: flex;
        gap: 10px;
    }
    
    .search-input {
        padding: 8px 12px;
        background-color: rgba(0,0,0,0.5);
        border: 1px solid var(--card-border);
        border-radius: 4px;
        color: var(--text-color);
        font-family: 'Consolas', monospace;
        width: 300px;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: var(--border-glow);
    }
    
    .credential-card {
        background-color: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 8px;
        padding: 20px;
        transition: all 0.3s;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    
    .credential-card:hover {
        border-color: var(--accent);
        box-shadow: var(--hover-glow);
        transform: translateY(-2px);
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    
    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 10px 0;
        color: #fff;
    }
    
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        font-family: 'Consolas', monospace;
        text-transform: uppercase;
    }
    
    .badge-vm { background-color: rgba(255, 87, 34, 0.2); color: var(--cat-vm); border: 1px solid var(--cat-vm); }
    .badge-database { background-color: rgba(76, 175, 80, 0.2); color: var(--cat-db); border: 1px solid var(--cat-db); }
    .badge-ssh { background-color: rgba(156, 39, 176, 0.2); color: var(--cat-ssh); border: 1px solid var(--cat-ssh); }
    .badge-api { background-color: rgba(233, 30, 99, 0.2); color: var(--cat-api); border: 1px solid var(--cat-api); }
    .badge-webapp { background-color: rgba(33, 150, 243, 0.2); color: var(--cat-web); border: 1px solid var(--cat-web); }
    .badge-other { background-color: rgba(96, 125, 139, 0.2); color: var(--cat-other); border: 1px solid var(--cat-other); }
    
    .card-actions {
        display: flex;
        gap: 10px;
    }
    
    .action-icon {
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .action-icon:hover {
        color: var(--highlight);
    }
    
    .action-icon.delete:hover {
        color: #ff4d4d;
    }
    
    .data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .data-item {
        background-color: rgba(0,0,0,0.3);
        padding: 10px;
        border-radius: 4px;
        border-left: 2px solid var(--card-border);
    }
    
    .data-label {
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    
    .data-value {
        font-family: 'Consolas', monospace;
        font-size: 14px;
        color: var(--accent);
        display: flex;
        justify-content: space-between;
        align-items: center;
        word-break: break-all;
    }
    
    .data-value.notes {
        color: var(--text-color);
        font-family: 'Inter', sans-serif;
    }
    
    .empty-state {
        text-align: center;
        padding: 50px;
        color: #666;
        font-family: 'Consolas', monospace;
        border: 1px dashed #444;
        border-radius: 8px;
    }
</style>

<div class="page-header">
    <h1 class="page-title anim-slide-left">
        <?= isset($active_category) && $active_category ? htmlspecialchars($active_category) . ' Credentials' : 'All Credentials' ?>
        <span class="count-badge counter-anim" data-target="<?= count($credentials) ?>">0</span>
    </h1>
    
    <div class="search-bar anim-slide-right">
        <form action="<?= site_url('credentials') ?>" method="GET" style="display: flex; gap: 10px;">
            <?php if(isset($active_category) && $active_category): ?>
                <input type="hidden" name="category" value="<?= htmlspecialchars($active_category) ?>">
            <?php endif; ?>
            <input type="text" name="search" class="search-input" placeholder="Search label, host, user..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn"><i class="fas fa-search"></i></button>
        </form>
        <a href="<?= site_url('credentials/new') ?>" class="btn"><i class="fas fa-plus"></i> Add Credential</a>
    </div>
</div>

<?php if(empty($credentials)): ?>
    <div class="empty-state">
        <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
        <p>NO CREDENTIALS FOUND IN DATABANKS.</p>
    </div>
<?php else: ?>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(450px, 1fr)); gap: 20px;">
    <?php $delay = 0.1; foreach($credentials as $cred): ?>
        <?php 
            $badgeClass = 'badge-other';
            if ($cred['category'] == 'VM') $badgeClass = 'badge-vm';
            else if ($cred['category'] == 'Database') $badgeClass = 'badge-database';
            else if ($cred['category'] == 'SSH') $badgeClass = 'badge-ssh';
            else if ($cred['category'] == 'API Key') $badgeClass = 'badge-api';
            else if ($cred['category'] == 'Web App') $badgeClass = 'badge-webapp';
        ?>
        <div class="credential-card anim-fade-up" style="animation-delay: <?= $delay ?>s">
            <div class="card-header">
                <div>
                    <h3 class="card-title"><?= htmlspecialchars($cred['label']) ?></h3>
                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($cred['category']) ?></span>
                </div>
                <div class="card-actions">
                    <a href="<?= site_url('credentials/edit/'.$cred['id']) ?>" class="action-icon" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="<?= site_url('credentials/delete/'.$cred['id']) ?>" class="action-icon delete" onclick="return confirm('Are you sure you want to purge this record?')" title="Delete"><i class="fas fa-trash"></i></a>
                </div>
            </div>
            
            <div class="data-grid">
                <?php if(!empty($cred['host'])): ?>
                <div class="data-item">
                    <div class="data-label">Host</div>
                    <div class="data-value">
                        <?= htmlspecialchars($cred['host']) ?>
                        <i class="fas fa-copy copy-icon" onclick="copyToClipboard('<?= htmlspecialchars(addslashes($cred['host'])) ?>', this)"></i>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($cred['port'])): ?>
                <div class="data-item">
                    <div class="data-label">Port</div>
                    <div class="data-value">
                        <?= htmlspecialchars($cred['port']) ?>
                        <i class="fas fa-copy copy-icon" onclick="copyToClipboard('<?= htmlspecialchars(addslashes($cred['port'])) ?>', this)"></i>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($cred['username'])): ?>
                <div class="data-item">
                    <div class="data-label">Username</div>
                    <div class="data-value">
                        <?= htmlspecialchars($cred['username']) ?>
                        <i class="fas fa-copy copy-icon" onclick="copyToClipboard('<?= htmlspecialchars(addslashes($cred['username'])) ?>', this)"></i>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($cred['password'])): ?>
                <div class="data-item">
                    <div class="data-label">Password</div>
                    <div class="data-value">
                        <?= htmlspecialchars($cred['password']) ?>
                        <i class="fas fa-copy copy-icon" onclick="copyToClipboard('<?= htmlspecialchars(addslashes($cred['password'])) ?>', this)"></i>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if(!empty($cred['notes'])): ?>
            <div style="margin-top: 15px;">
                <div class="data-item">
                    <div class="data-label">Notes</div>
                    <div class="data-value notes">
                        <?= nl2br(htmlspecialchars($cred['notes'])) ?>
                        <i class="fas fa-copy copy-icon" style="align-self: flex-start" onclick="copyToClipboard('<?= htmlspecialchars(addslashes($cred['notes'])) ?>', this)"></i>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php $delay += 0.1; ?>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
