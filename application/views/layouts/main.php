<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Workspace - H - SMC</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Nalika Theme Colors */
            --bg-color: #152036;
            --sidebar-bg: #1b2a47;
            --topbar-bg: #152036;
            --accent: #E5A93C; /* Nalika often uses gold/orange or bright cyan accents */
            --text-color: #ffffff;
            --text-muted: #8b92a4;
            --card-bg: #1b2a47;
            --card-border: transparent;
            --sidebar-border: transparent;
            
            --cat-vm: #eb4b4b;
            --cat-db: #14c673;
            --cat-ssh: #a84bd2;
            --cat-api: #e74c3c;
            --cat-web: #2980b9;
            --cat-other: #8b92a4;
        }

        html {
            height: 100%;
            margin: 0;
        }

        body {
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            overflow: hidden;
            width: 100%;
        }

        /* Sidebar */
        .sidebar {
            width: 230px;
            min-width: 230px;
            flex-shrink: 0;
            background-color: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 10;
        }

        .sidebar-header {
            padding: 20px;
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            background: var(--sidebar-bg);
            letter-spacing: 1px;
        }
        
        .sidebar-header span {
            color: #E5A93C; /* Nalika Logo Accent */
        }

        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-section {
            padding: 15px 20px 5px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: block;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 400;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #24355a;
            color: #fff;
        }

        .nav-link.active {
            border-left: 3px solid var(--accent);
            padding-left: 17px; /* Compensate for border */
        }

        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            color: var(--text-muted);
            font-size: 16px;
        }
        
        .nav-link:hover i, .nav-link.active i {
            color: #fff;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        /* Sidebar Collapsed State */
        .sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar.collapsed {
            width: 70px;
            min-width: 70px;
        }
        .sidebar.collapsed .sidebar-header {
            font-size: 14px;
            padding: 20px 0;
        }
        .sidebar.collapsed .sidebar-header span { display: none; }
        .sidebar.collapsed .nav-section { display: none; }
        .sidebar.collapsed .nav-link span { display: none; }
        .sidebar.collapsed .nav-link {
            text-align: center;
            padding: 15px 0;
        }
        .sidebar.collapsed .nav-link.active {
            border-left: 3px solid var(--accent);
            padding-left: 0;
        }
        .sidebar.collapsed .nav-link i {
            margin: 0;
            font-size: 20px;
        }

        /* Topbar */
        .topbar {
            height: 60px;
            background-color: var(--topbar-bg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            z-index: 10;
            border-bottom: 1px solid rgba(255,255,255,0.02);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
            transition: color 0.2s;
        }
        .toggle-sidebar:hover { color: #fff; }

        .breadcrumbs {
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 400;
        }
        .breadcrumbs span { 
            color: #fff; 
            font-weight: 500; 
        }

        /* Global Search */
        .global-search {
            position: relative;
            margin-right: 25px;
        }
        .global-search input {
            background: #1b2a47;
            border: 1px solid transparent;
            border-radius: 6px;
            color: #fff;
            padding: 8px 15px 8px 35px;
            width: 250px;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            transition: all 0.3s;
        }
        .global-search input:focus {
            outline: none;
            border-color: var(--accent);
            width: 320px;
            background: #152036;
        }
        .global-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--accent);
            color: #152036;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .btn-logout {
            color: var(--text-muted);
            text-decoration: none;
            padding: 6px 14px;
            border-radius: 6px;
            transition: all 0.3s;
            font-size: 13px;
            background: rgba(255,255,255,0.05);
        }

        .btn-logout:hover {
            background-color: #eb4b4b;
            color: #fff;
        }

        /* Content Area */
        .content-area {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            position: relative;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            background-color: var(--bg-color);
        }

        /* Global Styles */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #24355a;
            color: #fff;
            border: none;
            border-radius: 30px;
            font-family: 'Roboto', sans-serif;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
        }

        .btn:hover {
            background-color: #314674;
            color: #fff;
        }

        .btn-danger {
            background-color: #eb4b4b;
        }

        .btn-danger:hover {
            background-color: #d13e3e;
            color: #fff;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #14c673;
            color: #fff;
            border: none;
        }

        /* Toast */
        #toast {
            visibility: hidden;
            min-width: 200px;
            background-color: var(--card-bg);
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 12px;
            position: fixed;
            z-index: 9999;
            right: 30px;
            bottom: 30px;
            font-size: 14px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.3s, bottom 0.3s;
        }

        #toast.show {
            visibility: visible;
            opacity: 1;
            bottom: 50px;
        }
        
        .copy-icon {
            cursor: pointer;
            color: var(--text-muted);
            margin-left: 8px;
            transition: all 0.2s;
        }
        
        .copy-icon:hover {
            color: #fff;
        }
        
        .copy-icon.copied {
            color: #14c673;
        }
        
        /* Grid background for main area removed for Nalika */
        .grid-bg {
            display: none;
        }
        
        .relative-z1 {
            position: relative;
            z-index: 1;
        }

        /* Modal & Form Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(21, 32, 54, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background-color: var(--card-bg);
            border: none;
            border-radius: 4px;
            width: 400px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .close-modal {
            cursor: pointer;
            color: var(--text-muted);
        }
        .close-modal:hover { color: #fff; }
        
        .modal-body {
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            color: var(--text-muted);
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            background-color: #152036;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #fff;
            font-family: 'Roboto', sans-serif;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #24355a;
        }

        /* Animations */
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .anim-slide-left {
            animation: slideInLeft 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .anim-slide-right {
            animation: slideInRight 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .anim-fade-up {
            animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .count-badge {
            background: rgba(0, 255, 209, 0.15);
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 14px;
            vertical-align: middle;
            margin-left: 10px;
            text-shadow: none;
            box-shadow: 0 0 10px rgba(0, 255, 209, 0.3);
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            Workspace - H - <span>SMC</span>
        </div>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="<?= site_url('home') ?>" class="nav-link <?= $this->router->fetch_class() == 'home' ? 'active' : '' ?>">
                    <i class="fas fa-home"></i> <span>Home Dashboard</span>
                </a>
            </li>
            
            <li class="nav-section">WORKSPACE - H - SMC</li>
            <li class="nav-item">
                <a href="<?= site_url('credentials') ?>" class="nav-link <?= $this->router->fetch_class() == 'credentials' && empty($active_category) && $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
                    <i class="fas fa-layer-group"></i> <span>All Credentials</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('credentials?category=VM') ?>" class="nav-link <?= (isset($active_category) && $active_category == 'VM') ? 'active' : '' ?>">
                    <i class="fas fa-server"></i> <span>Virtual Machines</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('credentials?category=Database') ?>" class="nav-link <?= (isset($active_category) && $active_category == 'Database') ? 'active' : '' ?>">
                    <i class="fas fa-database"></i> <span>Databases</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('credentials?category=SSH') ?>" class="nav-link <?= (isset($active_category) && $active_category == 'SSH') ? 'active' : '' ?>">
                    <i class="fas fa-terminal"></i> <span>SSH Keys</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('credentials?category=API Key') ?>" class="nav-link <?= (isset($active_category) && $active_category == 'API Key') ? 'active' : '' ?>">
                    <i class="fas fa-key"></i> <span>API Keys</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('credentials?category=Web App') ?>" class="nav-link <?= (isset($active_category) && $active_category == 'Web App') ? 'active' : '' ?>">
                    <i class="fas fa-globe"></i> <span>Web Apps</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('credentials?category=Other') ?>" class="nav-link <?= (isset($active_category) && $active_category == 'Other') ? 'active' : '' ?>">
                    <i class="fas fa-box"></i> <span>Others</span>
                </a>
            </li>
            
            <li class="nav-section">TASK MANAGEMENT</li>
            <li class="nav-item">
                <a href="<?= site_url('tasks') ?>" class="nav-link <?= $this->router->fetch_class() == 'tasks' ? 'active' : '' ?>">
                    <i class="fas fa-columns"></i> <span>Kanban Board</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('notes') ?>" class="nav-link <?= $this->router->fetch_class() == 'notes' ? 'active' : '' ?>">
                    <i class="fas fa-book"></i> <span>Notes</span>
                </a>
            </li>
            
            <li class="nav-section">CAREER & JOBS</li>
            <li class="nav-item">
                <a href="<?= site_url('applyjob') ?>" class="nav-link <?= $this->router->fetch_class() == 'applyjob' ? 'active' : '' ?>">
                    <i class="fas fa-briefcase"></i> <span>Apply Job</span>
                </a>
            </li>
            
            <li class="nav-section">FINANCE & TAX</li>
            <li class="nav-item">
                <a href="<?= site_url('incomes') ?>" class="nav-link <?= $this->router->fetch_class() == 'incomes' ? 'active' : '' ?>">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Income Tracker</span>
                </a>
            </li>

            <?php if($this->session->userdata('role') === 'admin' || $this->session->userdata('username') === 'hanif'): ?>
            <li class="nav-section">SYSTEM ADMIN</li>
            <li class="nav-item">
                <a href="<?= site_url('users') ?>" class="nav-link <?= $this->router->fetch_class() == 'users' ? 'active' : '' ?>">
                    <i class="fas fa-users-cog"></i> <span>User Management</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="main-content">
        <div class="grid-bg"></div>
        <div class="topbar">
            <div class="topbar-left">
                <button class="toggle-sidebar" onclick="document.querySelector('.sidebar').classList.toggle('collapsed')">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="breadcrumbs">
                    Home / <span><?= ucfirst($this->router->fetch_class()) ?></span>
                </div>
            </div>
            <div style="display: flex; align-items: center;">
                <div class="global-search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search everywhere (Ctrl+K)..." id="globalSearchInput">
                </div>
                <div class="user-info">
                    <div class="user-avatar"><?= strtoupper(substr($this->session->userdata('username') ?? 'HA', 0, 2)) ?></div>
                    <span style="color: #fff;"><?= $this->session->userdata('username') ?></span>
                    <a href="<?= site_url('logout') ?>" class="btn-logout" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </div>

        <div class="content-area relative-z1">
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </div>

    <div id="toast">Copied to clipboard!</div>

    <script>
        function copyToClipboard(text, iconElement) {
            const onSuccess = () => {
                const originalClass = iconElement.className;
                iconElement.className = 'fas fa-check copy-icon copied';
                
                const toast = document.getElementById("toast");
                toast.className = "show";
                
                setTimeout(() => {
                    iconElement.className = originalClass;
                    toast.className = toast.className.replace("show", "");
                }, 1500);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(onSuccess).catch(err => {
                    console.error('Failed to copy via Clipboard API: ', err);
                    fallbackCopyTextToClipboard(text, onSuccess);
                });
            } else {
                fallbackCopyTextToClipboard(text, onSuccess);
            }
        }

        function fallbackCopyTextToClipboard(text, onSuccess) {
            var textArea = document.createElement("textarea");
            textArea.value = text;
            
            // Avoid scrolling to bottom
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                var successful = document.execCommand('copy');
                if (successful) onSuccess();
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
            }

            document.body.removeChild(textArea);
        }

        // Global Search Hotkey
        const searchInput = document.getElementById('globalSearchInput');
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
        });

        // Trigger search on Enter
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const val = this.value.trim();
                if (val) {
                    window.location.href = '<?= site_url("search?q=") ?>' + encodeURIComponent(val);
                }
            }
        });

        // Counter Animation
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll('.counter-anim');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                if (target === 0) {
                    counter.innerText = "0";
                    return;
                }
                const duration = 1500; // ms
                const increment = target / (duration / 16); 
                
                let current = 0;
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.innerText = Math.ceil(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target;
                    }
                };
                setTimeout(updateCounter, 300); // slight delay before counting
            });
        });
    </script>
</body>
</html>
