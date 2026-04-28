<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student QR Code CRUD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >

    <style>
        :root {
            --bg-dark: #050505;
            --bg-card: rgba(255, 255, 255, 0.08);
            --bg-card-hover: rgba(255, 255, 255, 0.13);
            --border-soft: rgba(255, 255, 255, 0.16);
            --text-main: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.65);
            --text-faint: rgba(255, 255, 255, 0.42);
            --shadow-soft: 0 24px 70px rgba(0, 0, 0, 0.45);
            --radius-xl: 28px;
            --radius-lg: 20px;
            --radius-md: 14px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--text-main);
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.16), transparent 25%),
                radial-gradient(circle at bottom right, rgba(255, 255, 255, 0.08), transparent 25%),
                linear-gradient(135deg, #020202 0%, #0c0c0c 50%, #050505 100%);
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,0.7), transparent);
        }

        .app-shell {
            max-width: 1180px;
            margin: 0 auto;
            padding: 32px 18px 56px;
            animation: fadeIn 0.7s ease both;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
            padding: 18px 20px;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-xl);
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            box-shadow: var(--shadow-soft);
        }

        .brand-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .brand-subtitle {
            margin: 4px 0 0;
            color: var(--text-muted);
            font-size: 0.86rem;
        }

        .status-chip {
            padding: 10px 14px;
            border-radius: 999px;
            border: 1px solid var(--border-soft);
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 700;
        }

        .glass-panel {
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-xl);
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            animation: riseUp 0.65s ease both;
        }

        .page-header {
            margin-bottom: 22px;
        }

        .eyebrow {
            display: inline-flex;
            margin-bottom: 12px;
            padding: 7px 12px;
            border-radius: 999px;
            border: 1px solid var(--border-soft);
            background: rgba(255, 255, 255, 0.07);
            color: var(--text-faint);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .page-title {
            margin: 0;
            font-size: clamp(2rem, 5vw, 4rem);
            line-height: 0.95;
            font-weight: 900;
            letter-spacing: -0.07em;
        }

        .page-description {
            margin: 14px 0 0;
            max-width: 680px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .modern-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: 10px 16px;
            border-radius: 14px;
            border: 1px solid var(--border-soft);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            text-decoration: none;
            font-weight: 800;
            font-size: 0.9rem;
            transition: 0.22s ease;
            cursor: pointer;
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.32);
        }

        .modern-btn.primary {
            background: #ffffff;
            color: #050505;
            border-color: #ffffff;
        }

        .modern-btn.primary:hover {
            background: rgba(255,255,255,0.88);
            color: #050505;
        }

        .modern-btn.danger {
            background: rgba(255, 255, 255, 0.04);
            color: rgba(255,255,255,0.8);
        }

        .modern-input,
        .modern-textarea {
            width: 100%;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.07);
            color: #ffffff;
            padding: 13px 15px;
            outline: none;
            transition: 0.22s ease;
        }

        .modern-input:focus,
        .modern-textarea:focus {
            border-color: rgba(255,255,255,0.45);
            background: rgba(255,255,255,0.12);
            box-shadow: 0 0 0 4px rgba(255,255,255,0.06);
        }

        .modern-input::placeholder,
        .modern-textarea::placeholder {
            color: rgba(255,255,255,0.35);
        }

        .modern-label {
            margin-bottom: 8px;
            color: var(--text-faint);
            font-size: 0.76rem;
            font-weight: 900;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .form-card {
            max-width: 760px;
            margin: 0 auto;
            padding: 28px;
        }

        .field-group {
            margin-bottom: 18px;
        }

        .alert-modern {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-soft);
            background: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        .error-text {
            margin-top: 7px;
            color: rgba(255,255,255,0.72);
            font-size: 0.84rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes riseUp {
            from {
                opacity: 0;
                transform: translateY(22px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatSoft {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        @media (max-width: 768px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .status-chip {
                width: 100%;
                text-align: center;
            }

            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <main class="app-shell">
        <nav class="topbar">
            <div>
                <h1 class="brand-title">Student QR Dashboard</h1>
                <p class="brand-subtitle">CRUD system with QR code integration</p>
            </div>

            <div class="status-chip">
                QR Code Activity
            </div>
        </nav>

        @if(session('success'))
            <div class="alert-modern">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>