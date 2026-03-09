<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'LASK') }} | Laravel API Starter Kit</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <style>
            :root {
                color-scheme: light;
                --bg: #f4f7fb;
                --panel: rgba(255, 255, 255, 0.92);
                --panel-border: rgba(15, 23, 42, 0.08);
                --text: #0f172a;
                --muted: #64748b;
                --primary: #2563eb;
                --primary-soft: rgba(37, 99, 235, 0.1);
                --shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Instrument Sans', sans-serif;
                color: var(--text);
                background:
                    radial-gradient(circle at top left, rgba(37, 99, 235, 0.16), transparent 28%),
                    radial-gradient(circle at bottom right, rgba(16, 185, 129, 0.18), transparent 24%),
                    var(--bg);
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            code {
                font-family: Consolas, Monaco, monospace;
                font-size: 0.88rem;
            }

            .page {
                max-width: 1180px;
                margin: 0 auto;
                padding: 32px 20px 48px;
            }

            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 28px;
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .brand-mark {
                width: 48px;
                height: 48px;
                display: grid;
                place-items: center;
                border-radius: 16px;
                background: linear-gradient(135deg, #2563eb, #0f766e);
                color: #fff;
                font-weight: 700;
                letter-spacing: 0.08em;
                box-shadow: var(--shadow);
            }

            .brand-copy h1 {
                margin: 0;
                font-size: 1rem;
            }

            .brand-copy p {
                margin: 4px 0 0;
                color: var(--muted);
                font-size: 0.95rem;
            }

            .topbar-actions {
                display: flex;
                gap: 12px;
                align-items: center;
                flex-wrap: wrap;
            }

            .pill {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                border-radius: 999px;
                border: 1px solid var(--panel-border);
                background: rgba(255, 255, 255, 0.78);
                color: var(--muted);
                font-size: 0.94rem;
                backdrop-filter: blur(10px);
            }

            .button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 12px 18px;
                border-radius: 14px;
                border: 1px solid transparent;
                font-weight: 600;
                transition: 0.2s ease;
                cursor: pointer;
            }

            .button-primary {
                background: var(--primary);
                color: #fff;
                box-shadow: 0 16px 30px rgba(37, 99, 235, 0.24);
            }

            .button-secondary {
                background: rgba(255, 255, 255, 0.78);
                color: var(--text);
                border-color: var(--panel-border);
            }

            .button:hover {
                transform: translateY(-1px);
            }

            .hero {
                display: grid;
                grid-template-columns: minmax(0, 1.55fr) minmax(320px, 380px);
                gap: 24px;
                align-items: start;
            }

            .panel {
                background: var(--panel);
                border: 1px solid var(--panel-border);
                border-radius: 28px;
                box-shadow: var(--shadow);
                backdrop-filter: blur(14px);
            }

            .hero-panel {
                padding: 34px;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 12px;
                border-radius: 999px;
                background: var(--primary-soft);
                color: var(--primary);
                font-weight: 600;
                font-size: 0.9rem;
                margin-bottom: 18px;
            }

            .headline {
                margin: 0;
                font-size: clamp(2.4rem, 5vw, 4rem);
                line-height: 1.05;
                letter-spacing: -0.04em;
            }

            .subtitle {
                margin: 18px 0 0;
                max-width: 760px;
                font-size: 1.08rem;
                line-height: 1.75;
                color: var(--muted);
            }

            .brief-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 14px;
                margin-top: 28px;
            }

            .brief-card,
            .feature-card {
                padding: 18px;
                border-radius: 22px;
                border: 1px solid rgba(148, 163, 184, 0.16);
                background: rgba(248, 250, 252, 0.9);
            }

            .brief-card strong,
            .feature-card strong {
                display: block;
                margin-bottom: 8px;
                font-size: 1rem;
            }

            .brief-card span,
            .feature-card span {
                color: var(--muted);
                line-height: 1.6;
                font-size: 0.95rem;
            }

            .section-title {
                margin: 34px 0 14px;
                font-size: 1.06rem;
            }

            .feature-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }

            .package-strip {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 20px;
            }

            .package-badge {
                padding: 10px 14px;
                border-radius: 999px;
                background: rgba(15, 23, 42, 0.04);
                color: var(--muted);
                font-size: 0.92rem;
            }

            .auth-panel {
                padding: 26px;
                position: sticky;
                top: 24px;
            }

            .auth-panel h2 {
                margin: 0 0 8px;
                font-size: 1.45rem;
            }

            .auth-panel p {
                margin: 0 0 22px;
                color: var(--muted);
                line-height: 1.7;
            }

            .field {
                display: flex;
                flex-direction: column;
                gap: 8px;
                margin-bottom: 16px;
            }

            .field label {
                font-size: 0.92rem;
                font-weight: 600;
            }

            .field input {
                width: 100%;
                padding: 14px 16px;
                border-radius: 14px;
                border: 1px solid rgba(148, 163, 184, 0.32);
                background: #fff;
                font: inherit;
                color: var(--text);
            }

            .field input:focus {
                outline: 2px solid rgba(37, 99, 235, 0.15);
                border-color: rgba(37, 99, 235, 0.36);
            }

            .form-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin: 6px 0 20px;
                font-size: 0.92rem;
                color: var(--muted);
            }

            .checkbox {
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .checkbox input {
                accent-color: var(--primary);
            }

            .error-list,
            .flash-card,
            .demo-card {
                margin-bottom: 18px;
                padding: 14px 16px;
                border-radius: 16px;
                font-size: 0.92rem;
                line-height: 1.6;
            }

            .error-list {
                background: rgba(239, 68, 68, 0.08);
                border: 1px solid rgba(239, 68, 68, 0.2);
                color: #b91c1c;
            }

            .flash-card {
                background: rgba(16, 185, 129, 0.1);
                border: 1px solid rgba(16, 185, 129, 0.24);
                color: #047857;
            }

            .demo-card {
                background: rgba(37, 99, 235, 0.08);
                border: 1px solid rgba(37, 99, 235, 0.16);
                color: #1d4ed8;
            }

            .mini-note {
                margin-top: 16px;
                color: var(--muted);
                font-size: 0.9rem;
                line-height: 1.6;
            }

            @media (max-width: 980px) {
                .hero {
                    grid-template-columns: 1fr;
                }

                .auth-panel {
                    position: static;
                }

                .brief-grid,
                .feature-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 640px) {
                .page {
                    padding: 20px 14px 32px;
                }

                .hero-panel,
                .auth-panel {
                    padding: 22px;
                }

                .topbar {
                    align-items: flex-start;
                    flex-direction: column;
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <header class="topbar">
                <div class="brand">
                    <div class="brand-mark">LS</div>
                    <div class="brand-copy">
                        <h1>{{ config('app.name', 'LASK') }}</h1>
                        <p>Laravel API Starter Kit for fast backend project setup.</p>
                    </div>
                </div>

                <div class="topbar-actions">
                    <div class="pill">Laravel 12 | Sanctum | Roles/Permissions | Telescope</div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="button button-primary">Open Dashboard</a>
                    @else
                        <a href="#login-card" class="button button-secondary">Sign In</a>
                    @endauth
                </div>
            </header>

            <main class="hero">
                <section class="panel hero-panel">
                    <div class="eyebrow">README summary</div>
                    <h1 class="headline">A lightweight Laravel backend starter kit with auth, logging, roles, and monitoring already wired in.</h1>
                    <p class="subtitle">
                        LASK is built to speed up API-driven projects. It gives you Laravel 12 with Sanctum authentication,
                        audit-friendly logging, permission management, dynamic navigation support, and built-in observability
                        through logs, Telescope, and Spatie Health.
                    </p>

                    <div class="brief-grid">
                        <article class="brief-card">
                            <strong>Authentication ready</strong>
                            <span>Sanctum-based auth is already included so new modules can plug into a secure base quickly.</span>
                        </article>
                        <article class="brief-card">
                            <strong>Operational visibility</strong>
                            <span>Activity logs, Telescope, log viewing, and health checks help you debug and monitor faster.</span>
                        </article>
                        <article class="brief-card">
                            <strong>Modular foundation</strong>
                            <span>Roles, permissions, soft deletes, and dynamic navigation make the project reusable across apps.</span>
                        </article>
                    </div>

                    <h2 class="section-title">What is included</h2>
                    <div class="feature-grid">
                        <article class="feature-card">
                            <strong>API-first starter</strong>
                            <span>Designed for REST backends that can be consumed by Vue, React, Angular, or mobile clients.</span>
                        </article>
                        <article class="feature-card">
                            <strong>Logging and auditing</strong>
                            <span>Request logging, activity history, login tracking, and file logs are part of the default stack.</span>
                        </article>
                        <article class="feature-card">
                            <strong>Permission management</strong>
                            <span>Role and permission support is preconfigured to keep authorization consistent across modules.</span>
                        </article>
                        <article class="feature-card">
                            <strong>Health and diagnostics</strong>
                            <span>Use the dashboard to jump into logs, Telescope, and live Laravel/MySQL health summaries.</span>
                        </article>
                    </div>

                    <div class="package-strip">
                        <span class="package-badge">Laravel Sanctum</span>
                        <span class="package-badge">Spatie Permission</span>
                        <span class="package-badge">Spatie Laravel Health</span>
                        <span class="package-badge">Laravel Telescope</span>
                        <span class="package-badge">Laravel Log Viewer</span>
                    </div>
                </section>

                <aside class="panel auth-panel" id="login-card">
                    @auth
                        <h2>Signed in</h2>
                        <p>You are already authenticated. Open the dashboard to access logs, Telescope, and the health overview.</p>
                        <a href="{{ route('dashboard') }}" class="button button-primary" style="width: 100%;">Go to Dashboard</a>
                        <div class="mini-note">
                            The dashboard also exposes the live active-connections endpoint at
                            <code>{{ route('health.connections') }}</code>.
                        </div>
                    @else
                        <h2>Sign in</h2>
                        <br>
                        @if ($errors->any())
                            <div class="error-list">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="flash-card">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf

                            <div class="field">
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                            </div>

                            <div class="field">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" autocomplete="current-password" required>
                            </div>

                            <div class="form-row">
                                <label class="checkbox" for="remember">
                                    <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                                    <span>Remember me</span>
                                </label>
                                <span>Session-based web login</span>
                            </div>

                            <button type="submit" class="button button-primary" style="width: 100%;">Login to Dashboard</button>
                        </form>

                        <div class="mini-note">
                            After login you will land on a dedicated dashboard with quick access to package UIs and Laravel/MySQL
                            system stats.
                        </div>
                        
                        @if (app()->environment(['local', 'development']))
                            <div class="demo-card">
                                Demo account: <strong>superadmin@lask.com</strong><br>
                                Password: <strong>S.Admin.123</strong>
                            </div>
                        @endif

                    @endauth
                </aside>
            </main>
        </div>
    </body>
</html>
