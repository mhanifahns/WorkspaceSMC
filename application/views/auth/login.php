<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRED VAULT</title>
    <link href="https://fonts.googleapis.com/css2?family=Consolas:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0A0E1A;
            --accent: #00FFD1;
            --text-color: #C9D6E3;
            --highlight: #FFD700;
            --secondary: #00B8D9;
            --card-bg: rgba(10, 14, 26, 0.8);
            --border-glow: 0 0 15px rgba(0, 255, 209, 0.4);
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
            /* Subtle grid background */
            background-image: 
                linear-gradient(rgba(0, 255, 209, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 209, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .login-card {
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 8px;
            border: 1px solid var(--accent);
            box-shadow: var(--border-glow);
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(5px);
        }

        .login-title {
            font-family: 'Consolas', monospace;
            color: var(--accent);
            font-size: 28px;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(0, 255, 209, 0.5);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid #333;
            border-radius: 4px;
            color: var(--text-color);
            font-family: 'Consolas', monospace;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 8px rgba(0, 255, 209, 0.3);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
            border-radius: 4px;
            font-family: 'Consolas', monospace;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            background-color: var(--accent);
            color: var(--bg-color);
            box-shadow: var(--border-glow);
        }

        .alert-error {
            background-color: rgba(255, 0, 0, 0.1);
            border: 1px solid #ff4d4d;
            color: #ff4d4d;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-title">CRED VAULT</div>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert-error">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="POST">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="USERNAME" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="PASSWORD" required>
            </div>
            <button type="submit" class="btn-login">Initiate Access</button>
        </form>
    </div>

</body>
</html>
