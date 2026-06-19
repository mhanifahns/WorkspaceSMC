<!DOCTYPE html>
<html>
<head>
    <title>ATS Resume</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            background: #fff;
            line-height: 1.4;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        h1 { font-size: 24px; text-align: center; text-transform: uppercase; margin-bottom: 5px; }
        .contact-info { text-align: center; font-size: 13px; margin-bottom: 20px; }
        .contact-info a { color: #000; text-decoration: none; }
        
        h2 { font-size: 14px; text-transform: uppercase; border-bottom: 1px solid #000; padding-bottom: 2px; margin-top: 20px; margin-bottom: 10px; }
        
        p { font-size: 12px; margin-bottom: 10px; }
        ul { margin: 0 0 10px 0; padding-left: 20px; font-size: 12px; }
        li { margin-bottom: 4px; }
        
        .exp-header { display: flex; justify-content: space-between; font-size: 13px; font-weight: bold; }
        .exp-role { font-style: italic; font-size: 13px; margin-bottom: 5px; }
        .exp-item { margin-bottom: 15px; }
        
        .skill-item { font-size: 12px; margin-bottom: 5px; }
        
        @media print {
            body { padding: 0; }
            button.print-btn { display: none; }
        }
        
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #24355a;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">🖨️ Print to PDF</button>

    <?php $basic = $cv['basic']; ?>
    <h1><?= htmlspecialchars($basic['name']) ?></h1>
    <div class="contact-info">
        <?= htmlspecialchars($basic['location']) ?> | <?= htmlspecialchars($basic['phone']) ?> | <?= htmlspecialchars($basic['email']) ?><br>
        <a href="<?= htmlspecialchars($basic['linkedin']) ?>"><?= htmlspecialchars($basic['linkedin']) ?></a> | 
        <a href="<?= htmlspecialchars($basic['portfolio']) ?>"><?= htmlspecialchars($basic['portfolio']) ?></a>
    </div>

    <h2>Professional Summary</h2>
    <p><?= nl2br(htmlspecialchars($cv['summary']['content'])) ?></p>

    <h2>Skills</h2>
    <?php foreach($cv['skills'] as $s): ?>
        <div class="skill-item"><strong><?= htmlspecialchars($s['category']) ?>:</strong> <?= htmlspecialchars($s['desc']) ?></div>
    <?php endforeach; ?>

    <h2>Work Experience</h2>
    <?php foreach($cv['experience'] as $e): ?>
        <div class="exp-item">
            <div class="exp-header">
                <span><?= htmlspecialchars($e['company']) ?></span>
                <span><?= htmlspecialchars($e['period']) ?></span>
            </div>
            <div class="exp-role"><?= htmlspecialchars($e['role']) ?></div>
            <ul>
                <?php 
                $lines = explode("\n", $e['desc']);
                foreach($lines as $line) {
                    $line = trim(str_replace('•', '', $line));
                    if($line) echo "<li>" . htmlspecialchars($line) . "</li>";
                }
                ?>
            </ul>
        </div>
    <?php endforeach; ?>

    <h2>Education</h2>
    <?php foreach($cv['education'] as $e): ?>
        <div class="exp-item">
            <div class="exp-header">
                <span><?= htmlspecialchars($e['school']) ?></span>
                <span><?= htmlspecialchars($e['period']) ?></span>
            </div>
            <div class="exp-role"><?= htmlspecialchars($e['degree']) ?> | GPA: <?= htmlspecialchars($e['gpa']) ?></div>
            <ul>
                <?php 
                $lines = explode("\n", $e['desc']);
                foreach($lines as $line) {
                    $line = trim(str_replace('•', '', $line));
                    if($line) echo "<li>" . htmlspecialchars($line) . "</li>";
                }
                ?>
            </ul>
        </div>
    <?php endforeach; ?>

</body>
</html>
