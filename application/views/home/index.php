<style>
    .home-dashboard {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .news-section {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .news-card {
        background-color: var(--card-bg);
        border: none;
        border-radius: 4px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .news-header {
        padding: 15px 20px;
        background-color: rgba(0,0,0,0.15);
        border-bottom: 1px solid rgba(255,255,255,0.05);
        font-family: 'Roboto', sans-serif;
        color: #fff;
        font-size: 15px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .news-list {
        list-style: none;
        padding: 20px;
        margin: 0;
        overflow-y: auto;
        max-height: 500px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    
    .news-item {
        background-color: #1A233A; /* Slightly lighter than card-bg for contrast */
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 8px;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .news-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        border-color: rgba(255,255,255,0.1);
    }
    
    .news-thumbnail-wrapper {
        width: 100%;
        height: 140px;
        overflow: hidden;
        background-color: #152036;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .news-thumbnail-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .news-thumbnail-wrapper i {
        font-size: 40px;
        color: rgba(255,255,255,0.1);
    }
    
    .news-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .news-title {
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 10px;
        line-height: 1.4;
        font-size: 14px;
    }
    
    .news-title:hover {
        color: var(--accent);
    }
    
    .news-meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
        font-size: 11px;
        color: var(--text-muted);
        margin-top: auto;
    }

    /* Stat card override for home */
    .stat-card-home {
        background-color: var(--card-bg);
        border: none;
        border-radius: 4px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        transition: transform 0.3s;
    }
    .stat-card-home:hover {
        transform: translateY(-3px);
    }
    .stat-card-home .stat-icon {
        font-size: 35px;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-card-home.tasks .stat-icon { background: rgba(229, 169, 60, 0.15); color: #E5A93C; }
    .stat-card-home.income .stat-icon { background: rgba(20, 198, 115, 0.15); color: #14c673; }
    
    .stat-card-home .stat-label { font-size: 13px; color: var(--text-muted); margin-bottom: 5px; font-weight: 500; letter-spacing: 0.5px; }
    .stat-card-home .stat-value { font-size: 32px; font-weight: 700; color: #fff; }
</style>

<div class="page-header" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <h1 class="page-title anim-slide-left" style="margin: 0;">
        <i class="fas fa-home"></i> Dashboard Home
    </h1>
    <div style="display: flex; gap: 10px; align-items: center;">
        <button class="btn anim-fade-up" onclick="openNotifModal()" style="position: relative; background: #24355a; color: #fff; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-bell"></i>
            <?php if(!empty($notifications)): ?>
                <span style="position: absolute; top: -8px; right: -8px; background: #eb4b4b; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold;"><?= count($notifications) ?></span>
            <?php endif; ?>
        </button>
        <button class="btn anim-fade-up" onclick="openSettingsModal()" style="background: #24355a; color: #fff; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-cog"></i> Crawler Settings
        </button>
    </div>
</div>

<div class="home-dashboard">
    <div class="summary-cards anim-fade-up">
        <a href="<?= site_url('tasks') ?>" style="text-decoration: none;">
            <div class="stat-card-home tasks">
                <div class="stat-icon"><i class="fas fa-tasks"></i></div>
                <div>
                    <div class="stat-label">OPEN TASKS</div>
                    <div class="stat-value"><?= $open_tasks ?></div>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 8px;">
                        <span style="color: #14c673; font-weight: 500;"><i class="fas fa-arrow-down"></i> 2.4%</span> vs last week
                    </div>
                </div>
            </div>
        </a>
        <a href="<?= site_url('incomes') ?>" style="text-decoration: none;">
            <div class="stat-card-home income">
                <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                <div>
                    <div class="stat-label">TOTAL NET RECEIVED</div>
                    <div class="stat-value">Rp <?= number_format($net_received, 0, ',', '.') ?></div>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 8px;">
                        <span style="color: #14c673; font-weight: 500;"><i class="fas fa-arrow-up"></i> 15.2%</span> vs last month
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="news-section anim-fade-up" style="animation-delay: 0.2s;">
        <!-- Tech News -->
        <div class="news-card">
            <div class="news-header" style="justify-content: space-between;">
                <div><i class="fas fa-newspaper"></i> Latest IT & Software News</div>
                <input type="text" id="searchNews" placeholder="Search news..." style="background: #152036; border: 1px solid transparent; color: #fff; padding: 6px 12px; border-radius: 30px; font-family: 'Roboto', sans-serif; width: 150px; font-size: 12px; outline: none;">
            </div>
            <ul class="news-list" id="newsList">
                <?php if(empty($news)): ?>
                    <li style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-satellite-dish" style="font-size: 48px; color: #24355a; margin-bottom: 20px; display: block;"></i>
                        <h4 style="margin: 0 0 10px 0; color: #fff; font-weight: 500; font-size: 16px;">Connecting to Sources</h4>
                        <p style="font-size: 13px; margin: 0; line-height: 1.5;">Crawling the latest IT news from the internet...<br>Please stand by.</p>
                        <i class="fas fa-circle-notch fa-spin" style="margin-top: 20px; color: var(--accent); font-size: 20px;"></i>
                    </li>
                <?php else: ?>
                    <?php foreach($news as $item): ?>
                    <li class="news-item">
                        <div class="news-thumbnail-wrapper">
                            <?php if(!empty($item['thumbnail'])): ?>
                                <img src="<?= htmlspecialchars($item['thumbnail']) ?>" alt="Thumbnail">
                            <?php else: ?>
                                <i class="fas fa-image"></i>
                            <?php endif; ?>
                        </div>
                        <div class="news-content">
                            <a href="<?= $item['link'] ?>" target="_blank" class="news-title" title="<?= htmlspecialchars($item['title']) ?>"><?= htmlspecialchars($item['title']) ?></a>
                            <div class="news-meta">
                                <span><?= htmlspecialchars($item['source']) ?></span>
                                <span><?= date('d M Y, H:i', strtotime($item['pub_date'])) ?></span>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <div id="newsPagination" style="padding: 10px; display: flex; justify-content: center; gap: 5px; border-top: 1px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.3);"></div>
        </div>

        <!-- Tenders -->
        <div class="news-card">
            <div class="news-header" style="justify-content: space-between;">
                <div><i class="fas fa-briefcase"></i> IT Tender Opportunities</div>
                <input type="text" id="searchTenders" placeholder="Search tenders..." style="background: #152036; border: 1px solid transparent; color: #fff; padding: 6px 12px; border-radius: 30px; font-family: 'Roboto', sans-serif; width: 150px; font-size: 12px; outline: none;">
            </div>
            <ul class="news-list" id="tendersList">
                <?php if(empty($tenders)): ?>
                    <li style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-folder-open" style="font-size: 48px; color: #24355a; margin-bottom: 20px; display: block;"></i>
                        <h4 style="margin: 0 0 10px 0; color: #fff; font-weight: 500; font-size: 16px;">No Opportunities Yet</h4>
                        <p style="font-size: 13px; margin: 0; line-height: 1.5;">Scanning for matching tender projects.<br>We'll notify you when something comes up.</p>
                        <i class="fas fa-circle-notch fa-spin" style="margin-top: 20px; color: var(--accent); font-size: 20px;"></i>
                    </li>
                <?php else: ?>
                    <?php foreach($tenders as $item): ?>
                    <li class="news-item">
                        <div class="news-thumbnail-wrapper">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="news-content">
                            <a href="<?= $item['link'] ?>" target="_blank" class="news-title" title="<?= htmlspecialchars($item['title']) ?>"><?= htmlspecialchars($item['title']) ?></a>
                            <div class="news-meta">
                                <span><?= htmlspecialchars($item['source']) ?></span>
                                <span><?= date('d M Y, H:i', strtotime($item['pub_date'])) ?></span>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <div id="tendersPagination" style="padding: 10px; display: flex; justify-content: center; gap: 5px; border-top: 1px solid rgba(255,215,0,0.1); background: rgba(0,0,0,0.3);"></div>
        </div>
    </div>
</div>

<script>
    // Daily Background Sync: Always check if today needs a crawl
    fetch('<?= site_url("home/check_news_status") ?>')
    .then(res => res.json())
    .then(data => {
        // Silent crawl, no automatic reload.
    });
</script>

<!-- Settings Modal -->
<div class="modal" id="settingsModal">
    <div class="modal-content" style="max-width: 500px; border: 1px solid var(--card-border);">
        <div class="modal-header">
            <h3 style="margin:0;"><i class="fas fa-cog"></i> Crawler Settings</h3>
            <i class="fas fa-times close-modal" onclick="closeSettingsModal()" style="cursor: pointer;"></i>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('home/save_settings') ?>" method="POST">
                <?php if($this->session->flashdata('success')): ?>
                    <div style="background-color: rgba(76, 175, 80, 0.1); border: 1px solid #4caf50; color: #4caf50; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label>IT News RSS URL</label>
                    <input type="url" name="news_rss_url" class="form-control" value="<?= htmlspecialchars($news_rss_url) ?>" required>
                    <small style="color: #888; margin-top: 5px; display: block;">Contoh: https://dev.to/feed/tag/programming atau https://news.ycombinator.com/rss</small>
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label>Tender Filter Keywords</label>
                    <textarea name="tender_keywords" class="form-control" rows="3" required><?= htmlspecialchars($tender_keywords) ?></textarea>
                    <small style="color: #888; margin-top: 5px; display: block;">Pisahkan dengan koma (,) atau garis lurus (|).</small>
                </div>
                <div style="margin-top: 25px; text-align: right;">
                    <button type="button" class="btn btn-outline-secondary" onclick="closeSettingsModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save & Re-crawl</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notif Modal -->
<div class="modal" id="notifModal">
    <div class="modal-content" style="max-width: 500px; border: 1px solid #FFD700;">
        <div class="modal-header" style="border-bottom: 1px solid rgba(255,215,0,0.2);">
            <h3 style="margin:0; color: #FFD700;"><i class="fas fa-bell"></i> Crawler Notifications</h3>
            <i class="fas fa-times close-modal" onclick="closeNotifModal()" style="cursor: pointer;"></i>
        </div>
        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
            <?php if(empty($notifications)): ?>
                <p style="color: #aaa; text-align: center; padding: 20px;">Tidak ada notifikasi error dari crawler.</p>
            <?php else: ?>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <?php foreach($notifications as $notif): ?>
                        <li style="padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); color: #FF5722; font-size: 13px;">
                            <div style="display: flex; gap: 10px;">
                                <i class="fas fa-exclamation-triangle" style="margin-top: 3px;"></i> 
                                <div>
                                    <?= htmlspecialchars($notif['message']) ?>
                                    <div style="font-size: 10px; color: #888; margin-top: 5px;"><?= date('d M Y, H:i', strtotime($notif['created_at'])) ?></div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Progressive Crawl Background Task
    fetch('<?= site_url("home/progressive_crawl") ?>')
        .then(r => r.json())
        .then(d => {
            if (d.new_data) {
                console.log("Progressive crawler found new IT tenders in background!");
            }
        }).catch(e => console.log(e));

    function openNotifModal() {
        document.getElementById('notifModal').style.display = 'flex';
        fetch('<?= site_url("home/mark_notifications_read") ?>'); // Delete in background
    }
    function closeNotifModal() {
        document.getElementById('notifModal').style.display = 'none';
        
        // Remove the red badge
        const badge = document.querySelector('button[onclick="openNotifModal()"] span');
        if (badge) badge.remove();
        
        // Empty the notification list visually
        const modalBody = document.querySelector('#notifModal .modal-body');
        if (modalBody) {
            modalBody.innerHTML = '<p style="color: #aaa; text-align: center; padding: 20px;">Tidak ada notifikasi error dari crawler.</p>';
        }
    }
    function openSettingsModal() {
        document.getElementById('settingsModal').style.display = 'flex';
    }
    function closeSettingsModal() {
        document.getElementById('settingsModal').style.display = 'none';
    }
    
    // Close modal if clicking outside
    window.onclick = function(event) {
        if (event.target == document.getElementById('settingsModal')) {
            closeSettingsModal();
        }
        if (event.target == document.getElementById('notifModal')) {
            closeNotifModal();
        }
    }

    // Pagination & Search Logic
    function initPagination(listId, searchId, paginationId, itemsPerPage) {
        const list = document.getElementById(listId);
        if (!list) return;
        const items = Array.from(list.getElementsByClassName('news-item'));
        if (items.length === 0) return;

        const searchInput = document.getElementById(searchId);
        const paginationContainer = document.getElementById(paginationId);
        let currentPage = 1;
        let filteredItems = [...items];

        function render() {
            items.forEach(item => item.style.display = 'none');

            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            filteredItems.slice(start, end).forEach(item => item.style.display = 'flex');

            paginationContainer.innerHTML = '';
            const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
            if (totalPages > 1) {
                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    btn.style.background = i === currentPage ? 'var(--accent)' : 'transparent';
                    btn.style.color = i === currentPage ? '#fff' : 'var(--text-muted)';
                    btn.style.border = 'none';
                    btn.style.padding = '4px 10px';
                    btn.style.borderRadius = '4px';
                    btn.style.cursor = 'pointer';
                    btn.style.fontFamily = 'Roboto, sans-serif';
                    btn.style.fontSize = '12px';
                    btn.onclick = () => { currentPage = i; render(); };
                    paginationContainer.appendChild(btn);
                }
            }
        }

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            filteredItems = items.filter(item => {
                const text = item.textContent.toLowerCase();
                return text.includes(query);
            });
            currentPage = 1;
            render();
        });

        render();
    }

    document.addEventListener('DOMContentLoaded', () => {
        initPagination('newsList', 'searchNews', 'newsPagination', 5);
        initPagination('tendersList', 'searchTenders', 'tendersPagination', 5);
    });
</script>
