<!-- Created by Hanif -->
<div style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            <h2 style="color: #fff; margin-top: 0; font-weight: 600; font-size: 24px;">
                <i class="fas fa-briefcase" style="color: var(--accent); margin-right: 10px;"></i>
                Job Application Kit
            </h2>
            <p style="color: var(--text-muted); line-height: 1.6; max-width: 800px; margin-bottom: 0;">
                Fitur ini dirancang sebagai <strong>Repository Elemen CV</strong> untuk mempercepat proses melamar kerja. 
                Saat mengisi formulir rekrutmen di website seperti Workday, Lever, atau Greenhouse, lu bisa dengan cepat melakukan <strong>Copy-Paste</strong> data terstruktur.
            </p>
        </div>
        <div>
            <a href="<?= site_url('applyjob/export_ats?lang=en') ?>" target="_blank" class="btn btn-outline" style="border: 1px solid var(--accent); color: var(--accent); padding: 8px 15px; text-decoration: none; border-radius: 6px; margin-right: 10px;">
                <i class="fas fa-file-pdf"></i> Export ATS (EN)
            </a>
            <a href="<?= site_url('applyjob/export_ats?lang=id') ?>" target="_blank" class="btn btn-outline" style="border: 1px solid var(--accent); color: var(--accent); padding: 8px 15px; text-decoration: none; border-radius: 6px;">
                <i class="fas fa-file-pdf"></i> Export ATS (ID)
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">
        <button class="cv-tab-btn active" onclick="switchTab('en')" id="tab-btn-en">🇬🇧 English CV</button>
        <button class="cv-tab-btn" onclick="switchTab('id')" id="tab-btn-id">🇮🇩 Indonesian CV</button>
        <button class="cv-tab-btn" onclick="switchTab('cover')" id="tab-btn-cover"><i class="fas fa-envelope"></i> Cover Letters</button>
    </div>

    <?php foreach(['en', 'id'] as $lang): $data = $cv_data[$lang]; ?>
    <div id="cv-<?= $lang ?>" class="cv-tab-content" style="<?= $lang == 'id' ? 'display:none;' : '' ?>">
        
        <!-- BASIC INFO -->
        <div class="cv-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 15px;">
                <h3 class="cv-section-title" style="margin-bottom:0; border:none; padding:0;"><i class="fas fa-user"></i> Basic Information</h3>
                <?php if($data['basic']): ?>
                <button class="btn-text-accent" onclick='openModal("basic", "<?= $lang ?>", <?= $data["basic"]["db_id"] ?>, <?= htmlspecialchars(json_encode($data["basic"]), ENT_QUOTES, "UTF-8") ?>)'><i class="fas fa-edit"></i> Edit Basic Info</button>
                <?php else: ?>
                <button class="btn-text-accent" onclick='openModal("basic", "<?= $lang ?>")'><i class="fas fa-plus"></i> Add Basic Info</button>
                <?php endif; ?>
            </div>
            <div class="cv-grid">
                <?php if($data['basic']): ?>
                    <?= generate_copy_field("Full Name", $data['basic']['name']) ?>
                    <?= generate_copy_field("Current Title", $data['basic']['title']) ?>
                    <?= generate_copy_field("Location", $data['basic']['location']) ?>
                    <?= generate_copy_field("Phone", $data['basic']['phone']) ?>
                    <?= generate_copy_field("Email", $data['basic']['email']) ?>
                    <?= generate_copy_field("Portfolio", $data['basic']['portfolio']) ?>
                    <?= generate_copy_field("LinkedIn", $data['basic']['linkedin']) ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="cv-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 15px;">
                <h3 class="cv-section-title" style="margin-bottom:0; border:none; padding:0;"><i class="fas fa-align-left"></i> Professional Summary</h3>
                <?php if($data['summary']): ?>
                <button class="btn-text-accent" onclick='openModal("summary", "<?= $lang ?>", <?= $data["summary"]["db_id"] ?>, <?= htmlspecialchars(json_encode($data["summary"]), ENT_QUOTES, "UTF-8") ?>)'><i class="fas fa-edit"></i> Edit Summary</button>
                <?php else: ?>
                <button class="btn-text-accent" onclick='openModal("summary", "<?= $lang ?>")'><i class="fas fa-plus"></i> Add Summary</button>
                <?php endif; ?>
            </div>
            <?php if($data['summary']): ?>
                <?= generate_copy_textarea("Summary", $data['summary']['content']) ?>
            <?php endif; ?>
        </div>

        <!-- EXPERIENCE -->
        <div class="cv-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 15px;">
                <h3 class="cv-section-title" style="margin-bottom:0; border:none; padding:0;"><i class="fas fa-building"></i> Work Experience</h3>
                <button class="btn-text-accent" onclick="openModal('experience', '<?= $lang ?>')"><i class="fas fa-plus"></i> Add Experience</button>
            </div>
            
            <?php foreach($data['experience'] as $idx => $exp): ?>
            <div class="cv-experience" style="<?= $idx > 0 ? 'margin-top:25px;' : '' ?>">
                <div style="display:flex; justify-content:space-between;">
                    <h4><?= htmlspecialchars($exp['company']) ?></h4>
                    <div>
                        <button class="btn-text-accent" style="margin-right:10px;" onclick='openModal("experience", "<?= $lang ?>", <?= $exp["db_id"] ?>, <?= htmlspecialchars(json_encode($exp), ENT_QUOTES, "UTF-8") ?>)'><i class="fas fa-edit"></i></button>
                        <button class="btn-text-danger" onclick="deleteItem(<?= $exp['db_id'] ?>)"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="cv-exp-meta"><?= htmlspecialchars($exp['role']) ?> • <?= htmlspecialchars($exp['period']) ?></div>
                <?= generate_copy_textarea("Responsibilities", $exp['desc']) ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- EDUCATION -->
        <div class="cv-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 15px;">
                <h3 class="cv-section-title" style="margin-bottom:0; border:none; padding:0;"><i class="fas fa-graduation-cap"></i> Education</h3>
                <button class="btn-text-accent" onclick="openModal('education', '<?= $lang ?>')"><i class="fas fa-plus"></i> Add Education</button>
            </div>
            
            <?php foreach($data['education'] as $idx => $edu): ?>
            <div class="cv-experience" style="<?= $idx > 0 ? 'margin-top:25px;' : '' ?>">
                <div style="display:flex; justify-content:space-between;">
                    <h4><?= htmlspecialchars($edu['school']) ?></h4>
                    <div>
                        <button class="btn-text-accent" style="margin-right:10px;" onclick='openModal("education", "<?= $lang ?>", <?= $edu["db_id"] ?>, <?= htmlspecialchars(json_encode($edu), ENT_QUOTES, "UTF-8") ?>)'><i class="fas fa-edit"></i></button>
                        <button class="btn-text-danger" onclick="deleteItem(<?= $edu['db_id'] ?>)"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="cv-exp-meta"><?= htmlspecialchars($edu['degree']) ?> • <?= htmlspecialchars($edu['period']) ?></div>
                <?= generate_copy_field("GPA", $edu['gpa']) ?>
                <div style="margin-top:10px;">
                    <?= generate_copy_textarea("Description", $edu['desc']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- SKILLS -->
        <div class="cv-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 15px;">
                <h3 class="cv-section-title" style="margin-bottom:0; border:none; padding:0;"><i class="fas fa-tools"></i> Skills</h3>
                <button class="btn-text-accent" onclick="openModal('skills', '<?= $lang ?>')"><i class="fas fa-plus"></i> Add Skill Group</button>
            </div>
            
            <div class="cv-grid">
                <?php foreach($data['skills'] as $skill): ?>
                <div style="position:relative;">
                    <?= generate_copy_textarea($skill['category'], $skill['desc']) ?>
                    <div style="position:absolute; top:0; right:100px;">
                        <button class="btn-text-accent" style="margin-right:10px;" onclick='openModal("skills", "<?= $lang ?>", <?= $skill["db_id"] ?>, <?= htmlspecialchars(json_encode($skill), ENT_QUOTES, "UTF-8") ?>)'><i class="fas fa-edit"></i></button>
                        <button class="btn-text-danger" onclick="deleteItem(<?= $skill['db_id'] ?>)"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    <?php endforeach; ?>

    <!-- COVER LETTER TAB -->
    <div id="cv-cover" class="cv-tab-content" style="display:none;">
        <div class="cv-card">
            <h3 class="cv-section-title"><i class="fas fa-envelope-open-text"></i> Standard Cold Email (English)</h3>
            <?= generate_copy_textarea("Template 1", "Dear Hiring Manager,\n\nI am writing to express my interest in the Senior Backend Engineer position at [Company]. With over 8 years of experience designing and delivering scalable backend systems, cloud architectures, and enterprise platforms, I am confident in my ability to contribute effectively to your engineering team.\n\nIn my current role as Technical Lead at PT Data Nusantara Adhikarya, I successfully designed secure backend architectures handling core production workloads and led the implementation of ISMS (ISO/IEC 27001). My expertise lies in Node.js, Go, microservices, and GCP.\n\nI have attached my resume for your review. I would welcome the opportunity to discuss how my technical leadership and hands-on engineering background align with the goals of your team.\n\nThank you for your time and consideration.\n\nBest regards,\nMohammad Hanifah Nur Shafrudin\n+6285880657769 | mohanifahns@gmail.com") ?>
        </div>
        
        <div class="cv-card">
            <h3 class="cv-section-title"><i class="fas fa-envelope-open-text"></i> Standard Cover Letter (Indonesian)</h3>
            <?= generate_copy_textarea("Template 2", "Yth. HRD Manager / Tim Rekrutmen,\n\nMelalui email ini, saya bermaksud menyampaikan ketertarikan saya untuk melamar posisi Senior Backend Engineer / Technical Lead di [Perusahaan]. Dengan lebih dari 8 tahun pengalaman dalam merancang sistem backend yang scalable dan arsitektur cloud, saya yakin dapat memberikan kontribusi positif bagi tim engineering Anda.\n\nSaat ini saya menjabat sebagai Technical Lead di PT Data Nusantara Adhikarya, di mana saya memimpin desain arsitektur layanan inti, pengembangan API, serta berhasil memimpin sertifikasi ISO/IEC 27001 untuk perusahaan. Saya memiliki keahlian teknis mendalam menggunakan Node.js, Go, arsitektur Microservices, serta infrastruktur GCP.\n\nBersama email ini saya lampirkan resume saya untuk informasi lebih rinci mengenai portofolio dan pengalaman saya. Saya sangat berharap dapat mendiskusikan lebih lanjut bagaimana kualifikasi saya sejalan dengan kebutuhan di [Perusahaan].\n\nTerima kasih atas waktu dan perhatian Anda.\n\nHormat saya,\nMohammad Hanifah Nur Shafrudin\n+6285880657769 | mohanifahns@gmail.com") ?>
        </div>
    </div>
</div>

<!-- Modal for Adding Item -->
<div id="cvModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#1b2a47; width:500px; max-width:90%; border-radius:12px; border:1px solid rgba(255,255,255,0.1); box-shadow:0 10px 40px rgba(0,0,0,0.5);">
        <div style="padding:20px; border-bottom:1px solid rgba(255,255,255,0.1); display:flex; justify-content:space-between;">
            <h3 style="margin:0; color:#fff;" id="modalTitle">Add Item</h3>
            <i class="fas fa-times close-modal" onclick="closeModal()" style="cursor:pointer; color:#aaa;"></i>
        </div>
        <div style="padding:20px;" id="modalFormContent">
            <!-- Dynamic Form Injected Here -->
        </div>
        <div style="padding:20px; border-top:1px solid rgba(255,255,255,0.1); text-align:right;">
            <button class="btn btn-outline" style="margin-right:10px; color:#aaa; border:none;" onclick="closeModal()">Cancel</button>
            <button class="btn" style="background:var(--accent); color:#000; border:none; padding:8px 20px; border-radius:4px; font-weight:bold;" onclick="saveItem()">Save</button>
        </div>
    </div>
</div>

<?php
function generate_copy_field($label, $value) {
    $id = 'field_' . md5($label . $value . rand());
    return '
    <div class="copy-field-container">
        <label class="copy-label">'.$label.'</label>
        <div class="copy-input-group">
            <input type="text" class="copy-input" id="'.$id.'" value="'.htmlspecialchars($value).'" readonly />
            <button class="copy-btn" onclick="copyToClipboard(\''.$id.'\', this, false)" title="Copy to clipboard">
                <i class="far fa-copy"></i>
            </button>
        </div>
    </div>';
}

function generate_copy_textarea($label, $value) {
    $id = 'area_' . md5($label . $value . rand());
    // Basic conversion for legacy plain text to HTML if needed
    if (strpos($value, '<') === false && strpos($value, '•') !== false) {
        $value = nl2br(htmlspecialchars($value));
    }
    return '
    <div class="copy-field-container" style="grid-column: 1 / -1;">
        <label class="copy-label" style="display:flex; justify-content:space-between;">
            <span>'.$label.'</span>
            <button class="copy-btn-text" onclick="copyToClipboard(\''.$id.'\', this, true)"><i class="far fa-copy"></i> Copy Text</button>
        </label>
        <div class="copy-rich-text" id="'.$id.'">'.$value.'</div>
    </div>';
}
?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<style>
    .cv-tab-btn { background: transparent; color: var(--text-muted); border: none; padding: 10px 20px; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 15px; cursor: pointer; border-radius: 8px; transition: all 0.2s; }
    .cv-tab-btn:hover { background: rgba(255,255,255,0.05); color: #fff; }
    .cv-tab-btn.active { background: rgba(0, 255, 209, 0.1); color: var(--accent); border: 1px solid rgba(0, 255, 209, 0.2); }
    .cv-card { background: #1b2a47; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 25px; margin-bottom: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
    .cv-section-title { color: #fff; margin-top: 0; margin-bottom: 20px; font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 10px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 15px; }
    .cv-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
    .cv-experience h4 { color: #fff; margin: 0 0 5px 0; font-size: 16px; }
    .cv-exp-meta { color: var(--accent); font-size: 13px; margin-bottom: 15px; font-family: 'JetBrains Mono', monospace; }
    .copy-field-container { display: flex; flex-direction: column; gap: 8px; }
    .copy-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
    .copy-input-group { display: flex; background: #111a2f; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; overflow: hidden; }
    .copy-input { flex: 1; background: transparent; border: none; color: #fff; padding: 10px 15px; font-family: 'JetBrains Mono', monospace; font-size: 13px; outline: none; }
    .copy-btn { background: rgba(255,255,255,0.05); border: none; border-left: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); padding: 0 15px; cursor: pointer; transition: all 0.2s; }
    .copy-btn:hover { background: var(--accent); color: #000; }
    
    .copy-rich-text { width: 100%; box-sizing:border-box; background: #111a2f; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #fff; padding: 15px; font-family: 'Inter', sans-serif; font-size: 14px; line-height: 1.6; max-height: 250px; overflow-y: auto; }
    .copy-rich-text ul, .copy-rich-text ol { margin-top: 0; padding-left: 20px; }
    .copy-rich-text p { margin-top: 0; margin-bottom: 10px; }
    .copy-rich-text p:last-child { margin-bottom: 0; }
    
    .copy-btn-text { background: transparent; border: none; color: var(--accent); cursor: pointer; font-size: 12px; font-weight: 600; transition: 0.2s; }
    .copy-btn-text:hover { color: #fff; }
    
    .btn-text-accent { background: transparent; border: none; color: var(--accent); cursor: pointer; font-size: 13px; font-weight: 600; }
    .btn-text-danger { background: transparent; border: none; color: #ff4d4d; cursor: pointer; font-size: 13px; transition: 0.2s;}
    .btn-text-danger:hover { background: rgba(255,77,77,0.1); border-radius:4px; padding: 2px 5px;}
    
    .form-control { width: 100%; box-sizing: border-box; background: #111a2f; border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 10px; border-radius: 4px; font-family: 'Inter', sans-serif; margin-bottom: 10px;}
    .form-control:focus { outline: none; border-color: var(--accent); }

    /* Quill overrides for dark mode */
    .ql-toolbar.ql-snow { background: #111a2f; border: 1px solid rgba(255,255,255,0.1); border-radius: 4px 4px 0 0; border-bottom: none; }
    .ql-toolbar.ql-snow .ql-stroke { stroke: #fff; }
    .ql-toolbar.ql-snow .ql-fill { fill: #fff; }
    .ql-toolbar.ql-snow .ql-picker { color: #fff; }
    .ql-toolbar.ql-snow .ql-picker-options { background: #1b2a47; border: 1px solid rgba(255,255,255,0.1); }
    .ql-toolbar.ql-snow .ql-active .ql-stroke { stroke: var(--accent); }
    .ql-toolbar.ql-snow .ql-active .ql-fill { fill: var(--accent); }
    .ql-container.ql-snow { background: #111a2f; color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 0 0 4px 4px; font-family: 'Inter', sans-serif; font-size: 14px; }
    .ql-editor { min-height: 150px; }
    .ql-editor.ql-blank::before { color: var(--text-muted); font-style: normal; }
</style>

<script>
    function switchTab(lang) {
        document.querySelectorAll('.cv-tab-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.cv-tab-btn').forEach(el => el.classList.remove('active'));
        document.getElementById('cv-' + lang).style.display = 'block';
        document.getElementById('tab-btn-' + lang).classList.add('active');
    }

    function copyToClipboard(elementId, btnElement, isRichText) {
        var copyText = document.getElementById(elementId);
        
        if (isRichText) {
            // For rich text divs
            const range = document.createRange();
            range.selectNodeContents(copyText);
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand("copy");
            selection.removeAllRanges();
        } else {
            // For plain text inputs
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
        }
        
        let originalIcon = btnElement.innerHTML;
        if(btnElement.classList.contains('copy-btn-text')) {
            btnElement.innerHTML = '<i class="fas fa-check"></i> Copied!';
        } else {
            btnElement.innerHTML = '<i class="fas fa-check"></i>';
            btnElement.style.background = 'var(--accent)';
            btnElement.style.color = '#000';
        }
        setTimeout(() => {
            btnElement.innerHTML = originalIcon;
            if(!btnElement.classList.contains('copy-btn-text')) {
                btnElement.style.background = '';
                btnElement.style.color = '';
            }
        }, 1500);
    }

    // CRUD Logic
    let currentSection = '';
    let currentLang = '';
    let currentId = null;
    let quill = null;

    function initQuill() {
        if (!quill) {
            quill = new Quill('#quill_editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });
        }
    }

    function openModal(section, lang, editId = null, editData = null) {
        currentSection = section;
        currentLang = lang;
        currentId = editId;
        
        let html = '';
        let showQuill = false;
        let quillContent = '';

        if(section == 'basic') {
            document.getElementById('modalTitle').innerText = 'Edit Basic Info';
            let d = editData || {};
            html = `
                <input type="text" class="form-control" id="form_name" placeholder="Full Name" value="${d.name || ''}">
                <input type="text" class="form-control" id="form_title" placeholder="Title" value="${d.title || ''}">
                <input type="text" class="form-control" id="form_location" placeholder="Location" value="${d.location || ''}">
                <input type="text" class="form-control" id="form_phone" placeholder="Phone" value="${d.phone || ''}">
                <input type="text" class="form-control" id="form_email" placeholder="Email" value="${d.email || ''}">
                <input type="text" class="form-control" id="form_portfolio" placeholder="Portfolio URL" value="${d.portfolio || ''}">
                <input type="text" class="form-control" id="form_linkedin" placeholder="LinkedIn URL" value="${d.linkedin || ''}">
            `;
        } else if(section == 'summary') {
            document.getElementById('modalTitle').innerText = 'Edit Summary';
            let d = editData || {};
            showQuill = true;
            quillContent = d.content || '';
        } else if(section == 'experience') {
            document.getElementById('modalTitle').innerText = editId ? 'Edit Work Experience' : 'Add Work Experience';
            let d = editData || {};
            html = `
                <input type="text" class="form-control" id="form_company" placeholder="Company Name (e.g. PT Data Nusantara)" value="${d.company || ''}">
                <input type="text" class="form-control" id="form_role" placeholder="Role/Title (e.g. Technical Lead)" value="${d.role || ''}">
                <input type="text" class="form-control" id="form_period" placeholder="Period (e.g. 09/2023 - Current)" value="${d.period || ''}">
            `;
            showQuill = true;
            quillContent = d.desc || '';
        } else if(section == 'education') {
            document.getElementById('modalTitle').innerText = editId ? 'Edit Education' : 'Add Education';
            let d = editData || {};
            html = `
                <input type="text" class="form-control" id="form_school" placeholder="School/University Name" value="${d.school || ''}">
                <input type="text" class="form-control" id="form_degree" placeholder="Degree (e.g. Bachelor of Science)" value="${d.degree || ''}">
                <input type="text" class="form-control" id="form_period" placeholder="Graduation Date (e.g. 11/2016)" value="${d.period || ''}">
                <input type="text" class="form-control" id="form_gpa" placeholder="GPA (e.g. 3.50 / 4.00)" value="${d.gpa || ''}">
            `;
            showQuill = true;
            quillContent = d.desc || '';
        } else if(section == 'skills') {
            document.getElementById('modalTitle').innerText = editId ? 'Edit Skill Category' : 'Add Skill Category';
            let d = editData || {};
            html = `
                <input type="text" class="form-control" id="form_category" placeholder="Category (e.g. Languages & Frameworks)" value="${d.category || ''}">
            `;
            showQuill = true;
            quillContent = d.desc || '';
        }
        
        if (showQuill) {
            html += '<div id="quill_editor_wrapper" style="background:#fff; color:#000; margin-top:10px;"><div id="quill_editor"></div></div>';
        }

        document.getElementById('modalFormContent').innerHTML = html;
        document.getElementById('cvModal').style.display = 'flex';

        if (showQuill) {
            quill = null; // Re-initialize each time DOM is rebuilt
            initQuill();
            // Convert plain text bullets to HTML for older data if necessary
            if (quillContent.indexOf('<') === -1 && quillContent.indexOf('•') !== -1) {
                quillContent = quillContent.replace(/• /g, '<li>').replace(/\n/g, '</li>');
                quillContent = '<ul>' + quillContent + '</ul>';
            } else if (quillContent.indexOf('<') === -1) {
                quillContent = quillContent.replace(/\n/g, '<br>');
            }
            quill.root.innerHTML = quillContent;
        }
    }

    function closeModal() {
        document.getElementById('cvModal').style.display = 'none';
    }

    function saveItem() {
        let data = {};
        let htmlContent = quill ? quill.root.innerHTML : '';

        if(currentSection == 'basic') {
            data = {
                name: document.getElementById('form_name').value,
                title: document.getElementById('form_title').value,
                location: document.getElementById('form_location').value,
                phone: document.getElementById('form_phone').value,
                email: document.getElementById('form_email').value,
                portfolio: document.getElementById('form_portfolio').value,
                linkedin: document.getElementById('form_linkedin').value
            };
        } else if(currentSection == 'summary') {
            data = {
                content: htmlContent
            };
        } else if(currentSection == 'experience') {
            data = {
                company: document.getElementById('form_company').value,
                role: document.getElementById('form_role').value,
                period: document.getElementById('form_period').value,
                desc: htmlContent
            };
        } else if(currentSection == 'education') {
            data = {
                school: document.getElementById('form_school').value,
                degree: document.getElementById('form_degree').value,
                period: document.getElementById('form_period').value,
                gpa: document.getElementById('form_gpa').value,
                desc: htmlContent
            };
        } else if(currentSection == 'skills') {
            data = {
                category: document.getElementById('form_category').value,
                desc: htmlContent
            };
        }

        let formData = new FormData();
        if(currentId) formData.append('id', currentId);
        formData.append('section', currentSection);
        formData.append('lang', currentLang);
        formData.append('data', JSON.stringify(data));

        fetch('<?= site_url("applyjob/save_item") ?>', {
            method: 'POST',
            body: formData
        }).then(r=>r.json()).then(res=>{
            window.location.reload();
        });
    }

    function deleteItem(id) {
        if(confirm('Are you sure you want to delete this item?')) {
            let formData = new FormData();
            formData.append('id', id);
            fetch('<?= site_url("applyjob/delete_item") ?>', {
                method: 'POST',
                body: formData
            }).then(r=>r.json()).then(res=>{
                window.location.reload();
            });
        }
    }
</script>
