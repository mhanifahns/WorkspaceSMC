<!-- Created by Hanif -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap');
    
    :root {
        /* Nexus Dev-Suite 2026 / Raw Aesthetics */
        --md-sys-color-background: #0B0F17;
        --md-sys-color-on-background: #F8F9FA;
        --md-sys-color-surface: transparent;
        --md-sys-color-surface-container-low: rgba(255, 255, 255, 0.02);
        --md-sys-color-surface-container: rgba(255, 255, 255, 0.05);
        --md-sys-color-surface-container-highest: rgba(255, 255, 255, 0.10);
        --md-sys-color-on-surface: #F8F9FA;
        --md-sys-color-on-surface-variant: #A0AABF;
        --md-sys-color-primary: #00FFD1;
        --md-sys-color-on-primary: #0B0F17;
        --md-sys-color-primary-container: rgba(0, 255, 209, 0.15);
        --md-sys-color-on-primary-container: #00FFD1;
        --md-sys-color-secondary-container: rgba(255, 255, 255, 0.15); /* Glassmorphism 15% */
        --md-sys-color-on-secondary-container: #FFFFFF;
        --md-sys-color-outline-variant: rgba(255, 255, 255, 0.15);
        --md-sys-color-error: #FF4D4D;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--md-sys-color-background);
        color: var(--md-sys-color-on-background);
        margin: 0;
        background-image: 
            linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 40px 40px; /* Grid-based raw aesthetic */
    }

    .notion-layout { 
        display: flex; 
        height: calc(100vh - 60px); 
        background: transparent; 
        margin: -30px; 
        overflow: hidden;
    }
    
    .notion-sidebar { 
        width: 280px; 
        background: var(--md-sys-color-secondary-container); 
        backdrop-filter: blur(12px);
        border-right: 1px solid var(--md-sys-color-outline-variant); 
        display: flex; 
        flex-direction: column; 
        border-radius: 0; /* Precision lines */
    }
    
    .notion-sidebar-header { 
        padding: 20px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        border-bottom: 1px solid var(--md-sys-color-outline-variant); 
    }
    
    .notion-sidebar-header span {
        color: var(--md-sys-color-on-surface);
        font-size: 15px;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
    }

    .notion-sidebar-header .btn {
        background: var(--md-sys-color-primary-container);
        color: var(--md-sys-color-on-primary-container);
        border-radius: 0; /* Sharp edges */
        padding: 6px 12px;
        border: 1px solid var(--md-sys-color-primary);
        transition: 0.2s;
        font-family: 'JetBrains Mono', monospace;
    }
    .notion-sidebar-header .btn:hover {
        background: var(--md-sys-color-primary);
        color: var(--md-sys-color-on-primary);
        box-shadow: 0 0 10px rgba(0, 255, 209, 0.4);
    }

    .notion-note-list { flex: 1; overflow-y: auto; padding: 12px; }
    
    .notion-note-item { 
        padding: 12px; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        color: var(--md-sys-color-on-surface-variant); 
        transition: background 0.2s, padding-left 0.2s;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid transparent;
        border-radius: 0; /* Raw Aesthetic */
        margin-bottom: 8px;
        background: var(--md-sys-color-surface-container-low);
    }
    
    .notion-note-item:hover { 
        background: var(--md-sys-color-surface-container-highest); 
        color: var(--md-sys-color-on-surface);
        border-color: var(--md-sys-color-outline-variant);
        padding-left: 16px; /* Purposeful Motion */
    }
    
    .notion-note-item.active { 
        background: var(--md-sys-color-primary-container); 
        color: var(--md-sys-color-on-primary-container); 
        border: 1px solid var(--md-sys-color-primary);
        border-left: 4px solid var(--md-sys-color-primary);
    }
    
    .notion-note-item-left { display: flex; align-items: center; gap: 12px; overflow: hidden;}
    .notion-delete-btn { 
        opacity: 0; 
        color: var(--md-sys-color-error); 
        border: 1px solid transparent; 
        background: transparent; 
        cursor: pointer; 
        padding: 4px;
        border-radius: 0;
        transition: 0.2s;
    }
    .notion-delete-btn:hover {
        background: rgba(255, 77, 77, 0.1);
        border-color: var(--md-sys-color-error);
    }
    .notion-note-item:hover .notion-delete-btn { opacity: 1; }
    
    .notion-editor-container { 
        flex: 1; 
        overflow-y: auto; 
        position: relative; 
        background: transparent;
    }
    
    .notion-cover { 
        width: 100%; 
        height: 32vh; 
        background-size: cover; 
        background-position: center; 
        position: relative; 
        transition: 0.3s; 
        background-color: var(--md-sys-color-surface-container); 
        border-bottom: 1px solid var(--md-sys-color-outline-variant);
    }
    
    .notion-cover:hover .cover-btns { opacity: 1; transform: translateY(0); }
    .cover-btns { 
        position: absolute; 
        bottom: 20px; 
        right: 30px; 
        opacity: 0; 
        transform: translateY(5px);
        transition: all 0.2s ease-out; 
        display: flex; 
        gap: 12px; 
    }
    
    .cover-btns .btn {
        background: var(--md-sys-color-secondary-container); /* Glassmorphism 15% */
        backdrop-filter: blur(10px);
        border: 1px solid var(--md-sys-color-outline-variant);
        color: var(--md-sys-color-on-surface);
        border-radius: 0;
        padding: 8px 16px;
        font-size: 13px;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 500;
        text-transform: uppercase;
        transition: background 0.2s, border-color 0.2s;
    }
    .cover-btns .btn:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: var(--md-sys-color-primary);
        color: var(--md-sys-color-primary);
    }

    .notion-page-content { max-width: 850px; margin: 0 auto; padding: 0 60px 100px; position: relative; }
    .notion-icon { 
        font-size: 64px; 
        margin-top: -50px; 
        margin-bottom: 20px; 
        position: relative; 
        z-index: 2; 
        cursor: pointer; 
        display: inline-flex; 
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        user-select: none;
        background: #1b2a47;
        border: 2px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }
    .notion-icon:hover { 
        transform: translateY(-4px); 
        border-color: rgba(255,255,255,0.15); 
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5); 
    }
    
    .notion-title { 
        font-size: 48px; 
        font-weight: 800; 
        letter-spacing: -1.5px;
        border: none; 
        background: transparent; 
        color: var(--md-sys-color-on-surface); 
        outline: none; 
        width: 100%; 
        margin-bottom: 30px; 
        padding-bottom: 10px;
        border-bottom: 1px solid var(--md-sys-color-outline-variant);
    }
    .notion-title:empty:before { content: attr(placeholder); color: var(--md-sys-color-outline-variant); }
    
    /* Editor.js dark theme overrides */
    .ce-block__content { color: var(--md-sys-color-on-surface); max-width: 100%; }
    .ce-toolbar__content { max-width: 100%; }
    .cdx-block { font-size: 16px; line-height: 1.8; color: var(--md-sys-color-on-surface-variant); }
    .ce-inline-toolbar, .ce-conversion-toolbar, .ce-settings { background: var(--md-sys-color-secondary-container); backdrop-filter: blur(12px); border: 1px solid var(--md-sys-color-outline-variant); border-radius: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.8); }
    .ce-inline-toolbar__buttons, .ce-conversion-tool, .ce-settings__button { color: var(--md-sys-color-on-surface); }
    .ce-inline-toolbar__buttons:hover, .ce-conversion-tool:hover, .ce-settings__button:hover { background: var(--md-sys-color-surface-container-highest); color: var(--md-sys-color-primary); }
    .tc-wrap { --color-border: var(--md-sys-color-outline-variant); --color-background: var(--md-sys-color-surface-container); --color-text: var(--md-sys-color-on-surface); }
    .ce-popover { background: var(--md-sys-color-secondary-container); backdrop-filter: blur(12px); border: 1px solid var(--md-sys-color-outline-variant); color: var(--md-sys-color-on-surface); border-radius: 0; box-shadow: 0 10px 40px rgba(0,0,0,0.8); }
    .ce-popover__item:hover { background: var(--md-sys-color-surface-container-highest); }
    .ce-popover__item-icon { background: transparent; color: var(--md-sys-color-on-surface); }
    .ce-code__textarea { background: #000; color: var(--md-sys-color-primary); border: 1px solid var(--md-sys-color-outline-variant); border-radius: 0; padding: 20px; font-family: 'JetBrains Mono', monospace; font-size: 14px; box-shadow: inset 0 0 10px rgba(0, 255, 209, 0.05); }
    
    /* Popups */
    .notion-popup { 
        position: absolute; 
        background: #1b2a47; 
        border: 1px solid rgba(255, 255, 255, 0.05); 
        border-radius: 12px; 
        padding: 15px; 
        z-index: 100; 
        box-shadow: 0 12px 40px rgba(0,0,0,0.6); 
        display: none; 
    }
    .icon-picker { width: 320px; top: 70px; left: 60px; grid-template-columns: repeat(5, 1fr); gap: 8px; }
    .icon-picker span { 
        font-size: 28px; 
        text-align: center; 
        cursor: pointer; 
        padding: 10px; 
        border-radius: 8px; 
        display: inline-block; 
        transition: all 0.2s; 
        border: 1px solid transparent;
    }
    .icon-picker span:hover { 
        background: rgba(255,255,255,0.05); 
        transform: scale(1.15); 
        border-color: rgba(255,255,255,0.1); 
    }
    
    .cover-picker { 
        width: 380px; 
        position: fixed; 
        top: 150px; 
        left: 50%; 
        transform: translateX(-50%); 
        background: var(--md-sys-color-secondary-container); 
        backdrop-filter: blur(20px);
        border: 1px solid var(--md-sys-color-primary); 
        border-radius: 0; 
        z-index: 1000; 
        box-shadow: 0 20px 60px rgba(0,0,0,0.9), 0 0 20px rgba(0, 255, 209, 0.2); 
        display: none; 
        flex-direction: column; 
        overflow: hidden;
    }
    .cover-picker-header { 
        padding: 16px 20px; 
        background: var(--md-sys-color-surface-container); 
        cursor: move; 
        font-weight: 700; 
        font-size: 13px; 
        font-family: 'JetBrains Mono', monospace;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        user-select: none; 
        color: var(--md-sys-color-on-surface);
        border-bottom: 1px solid var(--md-sys-color-outline-variant);
    }
    .cover-picker-body { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; padding: 20px; max-height: 400px; overflow-y: auto; }
    .cover-picker-body img { width: 100%; height: 90px; object-fit: cover; border-radius: 0; cursor: pointer; border: 1px solid var(--md-sys-color-outline-variant); transition: all 0.2s ease;}
    .cover-picker-body img:hover { border-color: var(--md-sys-color-primary); transform: scale(1.05); box-shadow: 0 4px 15px rgba(0, 255, 209, 0.4); z-index: 2; position: relative;}

    /* PDF Export Styles */
    .pdf-export-mode { background: #ffffff !important; font-family: 'Inter', Arial, sans-serif !important; }
    .pdf-export-mode * { color: #000000 !important; opacity: 1 !important; -webkit-text-fill-color: #000000 !important; }
    .pdf-export-mode .notion-page-content { padding: 0 !important; margin: 0 !important; max-width: none !important; }
    .pdf-export-mode .notion-title { font-weight: 800 !important; margin-top: 0; padding-top: 0; border: none !important; }
    .pdf-export-mode .notion-title:empty { display: none; }
    .pdf-export-mode .ce-block__content, 
    .pdf-export-mode .cdx-block, 
    .pdf-export-mode .ce-paragraph, 
    .pdf-export-mode .cdx-list__item { 
        max-width: 100% !important; 
        font-weight: 500 !important; 
    }
    .pdf-export-mode b, .pdf-export-mode strong { font-weight: 800 !important; }
    .pdf-export-mode .tc-wrap { --color-border: #ddd; --color-background: #f9f9f9; --color-text: #000000; }
    .pdf-export-mode .ce-code__textarea { background: #f4f4f4 !important; color: #d63384 !important; border: 1px solid #ddd !important; }
    .pdf-export-mode .notion-icon { display: none !important; }
    .pdf-export-mode .ce-toolbar { display: none !important; }
    .pdf-export-mode .cdx-block { font-size: 14px !important; line-height: 1.5 !important; }
</style>

<div class="notion-layout">
    <div class="notion-sidebar">
        <div class="notion-sidebar-header">
            <span style="font-weight: 600; font-size: 14px;"><i class="fas fa-book"></i> My Workspace</span>
            <button class="btn btn-sm" onclick="createNewNote()" style="border:none; background:transparent; color:#fff;"><i class="fas fa-plus"></i></button>
        </div>
        <div class="notion-note-list" id="noteList">
            <?php foreach($notes as $note): ?>
                <div class="notion-note-item" id="note-btn-<?= $note['id'] ?>">
                    <div class="notion-note-item-left" onclick="loadNote(<?= $note['id'] ?>)" style="flex: 1;">
                        <span><?= htmlspecialchars($note['icon']) ?></span>
                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($note['title']) ?></span>
                    </div>
                    <button class="notion-delete-btn" onclick="deleteNote(<?= $note['id'] ?>)"><i class="fas fa-trash"></i></button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="notion-editor-container" id="editorView" style="display: none;">
        <div class="notion-cover" id="coverImage" style="background-image: url('https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=1200&q=80');">
            <div class="cover-btns">
                <button class="btn btn-sm btn-dark" style="background: rgba(0,0,0,0.6); border: none; color: white; margin-right: 5px;" onclick="exportPDF()"><i class="fas fa-file-pdf"></i> Export PDF</button>
                <button class="btn btn-sm btn-dark" style="background: rgba(0,0,0,0.6); border: none; color: white;" onclick="toggleCoverPicker(event)"><i class="fas fa-image"></i> Change cover</button>
            </div>
        </div>
        <div class="notion-page-content">
            <div class="notion-icon" onclick="toggleIconPicker(event)" id="noteIcon" title="Click to change icon">📄</div>
            <div class="notion-popup icon-picker" id="iconPicker"></div>
            <h1 class="notion-title" contenteditable="true" id="noteTitle" placeholder="Untitled" onblur="saveNote()"></h1>
            <div id="editorjs"></div>
        </div>
    </div>
    
    <!-- Empty State -->
    <div class="notion-editor-container" id="emptyView" style="display: flex; align-items: center; justify-content: center; flex-direction: column; color: #666;">
        <i class="fas fa-file-alt" style="font-size: 64px; margin-bottom: 20px; opacity: 0.2;"></i>
        <h3>Select a note or create a new one</h3>
    </div>
    
    <!-- Draggable Cover Picker Modal -->
    <div class="cover-picker" id="coverPicker">
        <div class="cover-picker-header" id="coverPickerHeader">
            <span><i class="fas fa-image"></i> Select Cover</span>
            <i class="fas fa-times" style="cursor:pointer;" onclick="toggleCoverPicker(event)"></i>
        </div>
        <div class="cover-picker-body" id="coverPickerBody"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    let editor = null;
    let currentNoteId = null;
    let saveTimeout = null;

    function initEditor(contentData) {
        if (editor) {
            editor.destroy();
        }
        let toolsConfig = {};
        if (typeof Header !== 'undefined') toolsConfig.header = Header;
        if (typeof List !== 'undefined') toolsConfig.list = List;
        if (typeof Checklist !== 'undefined') toolsConfig.checklist = Checklist;
        if (typeof Quote !== 'undefined') toolsConfig.quote = Quote;
        if (typeof CodeTool !== 'undefined') toolsConfig.code = CodeTool;
        
        editor = new EditorJS({
            holder: 'editorjs',
            placeholder: 'Press / for commands',
            data: contentData || {},
            tools: toolsConfig,
            onChange: () => {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(saveNote, 1000);
            }
        });
    }

    function createNewNote() {
        currentNoteId = null;
        document.getElementById('emptyView').style.display = 'none';
        document.getElementById('editorView').style.display = 'block';
        document.getElementById('noteTitle').innerText = 'Untitled';
        document.getElementById('noteIcon').innerText = '📄';
        document.getElementById('coverImage').style.backgroundImage = "url('https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=1200&q=80')";
        initEditor({});
        
        // Remove active classes
        document.querySelectorAll('.notion-note-item').forEach(el => el.classList.remove('active'));
    }

    function loadNote(id) {
        fetch('<?= site_url("notes/get/") ?>' + id)
            .then(r => r.json())
            .then(data => {
                currentNoteId = data.id;
                document.getElementById('emptyView').style.display = 'none';
                document.getElementById('editorView').style.display = 'block';
                document.getElementById('noteTitle').innerText = data.title;
                document.getElementById('noteIcon').innerText = data.icon;
                if(data.cover_image) {
                    document.getElementById('coverImage').style.backgroundImage = `url('${data.cover_image}')`;
                }
                
                let contentData = {};
                if (data.content) {
                    try { contentData = JSON.parse(data.content); } catch(e){}
                }
                initEditor(contentData);
                
                document.querySelectorAll('.notion-note-item').forEach(el => el.classList.remove('active'));
                let btn = document.getElementById('note-btn-' + id);
                if(btn) btn.classList.add('active');
            });
    }

    function deleteNote(id) {
        Swal.fire({
            title: 'Delete Note?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4d4d',
            cancelButtonColor: '#444',
            confirmButtonText: 'Yes, delete it!',
            background: '#2c2c2c',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= site_url("notes/delete/") ?>' + id).then(r => r.json()).then(res => {
                    window.location.reload();
                });
            }
        });
    }

    function saveNote() {
        if (!editor || document.getElementById('editorView').style.display === 'none') return;
        
        editor.save().then((outputData) => {
            const formData = new FormData();
            if (currentNoteId) formData.append('id', currentNoteId);
            formData.append('title', document.getElementById('noteTitle').innerText || 'Untitled');
            formData.append('content', JSON.stringify(outputData));
            formData.append('icon', document.getElementById('noteIcon').innerText);
            
            let bg = document.getElementById('coverImage').style.backgroundImage;
            let coverUrl = bg.replace('url("', '').replace('url(', '').replace('")', '').replace(')', '');
            formData.append('cover_image', coverUrl);

            fetch('<?= site_url("notes/save") ?>', {
                method: 'POST',
                body: formData
            }).then(r => r.json()).then(res => {
                if (!currentNoteId) {
                    currentNoteId = res.id;
                    // Dynamically append to sidebar
                    const list = document.getElementById('noteList');
                    const titleStr = document.getElementById('noteTitle').innerText || 'Untitled';
                    const iconStr = document.getElementById('noteIcon').innerText;
                    list.innerHTML += `
                        <div class="notion-note-item active" id="note-btn-${currentNoteId}">
                            <div class="notion-note-item-left" onclick="loadNote(${currentNoteId})" style="flex: 1;">
                                <span>${iconStr}</span>
                                <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${titleStr}</span>
                            </div>
                            <button class="notion-delete-btn" onclick="deleteNote(${currentNoteId})"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                } else {
                    let btn = document.getElementById('note-btn-' + currentNoteId);
                    if (btn) {
                        btn.querySelector('.notion-note-item-left span:nth-child(2)').innerText = document.getElementById('noteTitle').innerText || 'Untitled';
                        btn.querySelector('.notion-note-item-left span:nth-child(1)').innerText = document.getElementById('noteIcon').innerText;
                    }
                }
            });
        }).catch(err => console.log('Editor JS save error: ', err));
    }

    const availableIcons = ['📄', '🔥', '🚀', '💻', '💡', '📚', '🎯', '🎨', '🧠', '⭐', '🌈', '⚡', '🤖', '👾', '🌍', '📌', '📈', '🛠️', '🔒', '📝'];
    const availableCovers = [
        'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?auto=format&fit=crop&w=1200&q=80'
    ];

    document.getElementById('iconPicker').innerHTML = availableIcons.map(icon => `<span onclick="selectIcon('${icon}')">${icon}</span>`).join('');
    document.getElementById('coverPickerBody').innerHTML = availableCovers.map(cover => `<img src="${cover}" onclick="selectCover('${cover}')" />`).join('');

    function toggleIconPicker(e) {
        e.stopPropagation();
        document.getElementById('iconPicker').style.display = document.getElementById('iconPicker').style.display === 'grid' ? 'none' : 'grid';
        document.getElementById('coverPicker').style.display = 'none';
    }

    function toggleCoverPicker(e) {
        e.stopPropagation();
        document.getElementById('coverPicker').style.display = document.getElementById('coverPicker').style.display === 'flex' ? 'none' : 'flex';
        document.getElementById('iconPicker').style.display = 'none';
    }

    function selectIcon(icon) {
        document.getElementById('noteIcon').innerText = icon;
        document.getElementById('iconPicker').style.display = 'none';
        saveNote();
    }

    function selectCover(coverUrl) {
        document.getElementById('coverImage').style.backgroundImage = `url('${coverUrl}')`;
        document.getElementById('coverPicker').style.display = 'none';
        saveNote();
    }

    // Close popups on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#iconPicker') && !e.target.closest('#noteIcon')) {
            let p = document.getElementById('iconPicker');
            if(p) p.style.display = 'none';
        }
    });

    // Draggable logic for Cover Picker
    const coverPicker = document.getElementById('coverPicker');
    const coverPickerHeader = document.getElementById('coverPickerHeader');
    let isDragging = false, startX, startY, initialLeft, initialTop;

    coverPickerHeader.addEventListener('mousedown', function(e) {
        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;
        
        const rect = coverPicker.getBoundingClientRect();
        coverPicker.style.transform = 'none';
        coverPicker.style.left = rect.left + 'px';
        coverPicker.style.top = rect.top + 'px';
        
        initialLeft = rect.left;
        initialTop = rect.top;
    });

    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        coverPicker.style.left = (initialLeft + dx) + 'px';
        coverPicker.style.top = (initialTop + dy) + 'px';
    });

    document.addEventListener('mouseup', function() {
        isDragging = false;
    });
    
    document.getElementById('noteTitle').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            saveNote();
            if(editor && editor.caret) {
                try {
                    editor.caret.setToBlock(0, 'start');
                } catch(err) {
                    let firstBlock = document.querySelector('.ce-block__content [contenteditable="true"], .cdx-block[contenteditable="true"], .ce-paragraph');
                    if (firstBlock) firstBlock.focus();
                }
            } else {
                document.getElementById('editorjs').focus();
            }
        }
    });

    function exportPDF() {
        const element = document.querySelector('.notion-page-content').cloneNode(true);
        const picker = element.querySelector('#iconPicker');
        if (picker) picker.remove();
        
        const container = document.createElement('div');
        container.className = 'pdf-export-mode';
        container.appendChild(element);
        
        container.querySelectorAll('[contenteditable]').forEach(el => {
            el.removeAttribute('contenteditable');
        });

        let title = document.getElementById('noteTitle').innerText || 'Note';
        
        let opt = {
          margin:       15,
          filename:     title + '.pdf',
          image:        { type: 'jpeg', quality: 0.98 },
          html2canvas:  { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
          jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
          pagebreak:    { mode: ['css', 'legacy'] }
        };
        
        Swal.fire({
            title: 'Exporting PDF...',
            text: 'Please wait while we generate your PDF document.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
            background: '#2c2c2c',
            color: '#fff'
        });
        
        html2pdf().set(opt).from(container).save().then(() => {
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'Exported!',
                text: 'Your note has been exported to PDF.',
                background: '#2c2c2c',
                color: '#fff',
                timer: 1500,
                showConfirmButton: false
            });
        }).catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Export Failed',
                text: 'Something went wrong during PDF generation.',
                background: '#2c2c2c',
                color: '#fff'
            });
        });
    }
</script>
