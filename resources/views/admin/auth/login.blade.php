<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — {{ $settings['site_name'] ?? config('app.name') }} </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet" />
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3, .display { font-family: 'Syne', sans-serif; }

        body {
            background: #e8f4fd;
            min-height: 100vh;
        }

        .sky-bg {
            background: linear-gradient(180deg, #b8ddf7 0%, #d6ecf9 35%, #e8f4fd 65%, #f0f8ff 100%);
        }

        .cloud {
            position: absolute;
            background: white;
            border-radius: 50px;
            opacity: 0.6;
            filter: blur(8px);
            pointer-events: none;
        }
        @keyframes drift {
            from { transform: translateX(-320px); }
            to   { transform: translateX(calc(100vw + 320px)); }
        }
        .cloud-1 { width: 220px; height: 55px; bottom: 12%; left: -220px; animation: drift 28s linear infinite; }
        .cloud-2 { width: 300px; height: 70px; bottom: 6%;  left: -300px; animation: drift 38s linear 6s infinite; opacity: .4; }
        .cloud-3 { width: 160px; height: 45px; bottom: 18%; left: -160px; animation: drift 22s linear 12s infinite; opacity: .5; }
        .cloud-4 { width: 180px; height: 48px; top: 14%;   left: -180px; animation: drift 32s linear 4s infinite; opacity: .35; }

        .orbit-arc {
            position: absolute; left: 50%; top: 50%;
            transform: translate(-50%, -30%);
            border-radius: 50%;
            border: 1.5px solid rgba(180,210,240,.5);
            pointer-events: none;
        }
        @media (max-width: 480px) { .orbit-arc { display: none; } }

        .dot { position: absolute; border-radius: 50%; pointer-events: none; }
        @keyframes floatY {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-14px); }
        }

        .card {
            background: linear-gradient(145deg, rgba(255,255,255,.9) 0%, rgba(240,250,255,.84) 100%);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255,255,255,.75);
            box-shadow: 0 24px 64px rgba(100,160,210,.2), 0 2px 8px rgba(100,160,210,.1);
        }

        .icon-badge {
            background: linear-gradient(145deg, #ffffff, #e8f3fb);
            box-shadow: 0 4px 16px rgba(120,180,230,.2), inset 0 1px 0 rgba(255,255,255,.9);
        }

        .input-field {
            background: rgba(240,248,255,.7);
            border: 1.5px solid rgba(180,215,240,.5);
            border-radius: 12px;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(100,170,230,.12);
            background: rgba(255,255,255,.95);
        }
        .input-field.is-invalid {
            border-color: rgba(239,68,68,.5) !important;
            background: rgba(254,242,242,.7) !important;
        }
        .input-field.is-invalid:focus {
            border-color: rgba(239,68,68,.7) !important;
            box-shadow: 0 0 0 3px rgba(239,68,68,.1) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 4px 18px rgba(20,30,70,.28);
        }
        .btn-primary:hover  { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(20,30,70,.36); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary:disabled { opacity: .7; cursor: not-allowed; transform: none; }

        .admin-badge {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(80,140,210,.08));
            border: 1px solid rgba(100,170,230,.3);
            border-radius: 20px;
            font-family: 'Syne', sans-serif;
            letter-spacing: .08em;
        }

        .divider-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(180,215,240,.6), transparent);
        }

        .toggle-track {
            width: 34px; height: 18px;
            background: rgba(180,215,240,.6);
            border-radius: 9px;
            transition: background .2s;
            cursor: pointer;
            flex-shrink: 0;
            position: relative;
        }
        .toggle-track.on { background: #3b82f6; }
        .toggle-thumb {
            position: absolute;
            top: 2px; left: 2px;
            width: 14px; height: 14px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 1px 4px rgba(0,0,0,.2);
            transition: transform .2s;
        }
        .toggle-track.on .toggle-thumb { transform: translateX(16px); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .card-wrap { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) both; }
        .topbar    { animation: fadeUp .4s cubic-bezier(.22,1,.36,1) both; }

        .field-1 { animation: fadeUp .55s cubic-bezier(.22,1,.36,1) .15s both; }
        .field-2 { animation: fadeUp .55s cubic-bezier(.22,1,.36,1) .22s both; }
        .field-3 { animation: fadeUp .55s cubic-bezier(.22,1,.36,1) .29s both; }
        .field-4 { animation: fadeUp .55s cubic-bezier(.22,1,.36,1) .36s both; }

        .pw-toggle { cursor: pointer; }

        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 0px); }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%      { transform: translateX(-6px); }
            40%      { transform: translateX(6px); }
            60%      { transform: translateX(-4px); }
            80%      { transform: translateX(4px); }
        }
        .shake { animation: shake .4s ease; }

        .error-message {
            color: #ef4444;
            font-size: 0.7rem;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>

<body class="sky-bg flex flex-col items-center justify-center min-h-screen relative px-4 py-20 safe-bottom overflow-x-hidden">

    {{-- Clouds --}}
    <div class="cloud cloud-1"></div>
    <div class="cloud cloud-2"></div>
    <div class="cloud cloud-3"></div>
    <div class="cloud cloud-4"></div>

    {{-- Orbit arcs --}}
    <div class="orbit-arc" style="width:700px;height:700px;"></div>
    <div class="orbit-arc" style="width:520px;height:520px;border-color:rgba(180,210,240,.3);"></div>

    {{-- Floating accent dots --}}
    <div class="dot" style="width:8px;height:8px;background:rgba(100,170,230,.25);top:22%;left:8%;animation:floatY 5s ease-in-out infinite;"></div>
    <div class="dot" style="width:5px;height:5px;background:rgba(100,170,230,.2);top:35%;right:10%;animation:floatY 7s ease-in-out 1s infinite;"></div>
    <div class="dot" style="width:10px;height:10px;background:rgba(59, 130, 246, 0.15);bottom:30%;left:12%;animation:floatY 6s ease-in-out 2s infinite;"></div>

    {{-- Top bar --}}
    <div class="topbar fixed top-0 left-0 w-full flex items-center justify-between px-4 sm:px-8 py-3 sm:py-4 z-20"
         style="background:rgba(184,221,247,.45);backdrop-filter:blur(8px);">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 2L13 5.5V10.5L8 14L3 10.5V5.5L8 2Z" fill="white" opacity=".9"/>
                    <circle cx="8" cy="8" r="2.5" fill="#7dd3fc"/>
                </svg>
            </div>
            <span class="font-bold text-gray-900 text-base" style="font-family:'Syne',sans-serif;">
                {{ $settings['site_name'] ?? config('app.name') }}
            </span>
        </div>
        <a href="#" class="text-xs text-blue-500 hover:underline font-medium">Need help?</a>
    </div>

    {{-- Card --}}
    <div class="card-wrap relative z-10 w-full max-w-md">
        <div class="card rounded-3xl px-5 sm:px-8 pt-7 sm:pt-8 pb-6 sm:pb-7">

            {{-- Header --}}
            <div class="flex flex-col items-center mb-6">
                <div class="icon-badge w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mb-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1a1a2e" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        <circle cx="12" cy="16" r="1" fill="#1a1a2e"/>
                    </svg>
                </div>

                <div class="admin-badge px-3 py-1 mb-2.5 flex items-center gap-1.5">
                    <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                    <span class="text-xs text-blue-600 font-semibold uppercase tracking-widest">Admin Portal</span>
                </div>

                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">Welcome back</h1>
                <p class="text-xs text-gray-400 mt-1">Sign in to your admin account</p>
            </div>

            {{-- Session error (e.g. failed login from controller) --}}
            @if (session('error'))
                <div class="mb-4 px-4 py-3 rounded-2xl flex items-center gap-2.5"
                     style="background:rgba(254,242,242,.85);border:1px solid rgba(239,68,68,.2);">
                    <svg class="flex-shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span class="text-xs text-red-500 font-medium">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-2xl flex items-start gap-2.5"
                     style="background:rgba(254,242,242,.85);border:1px solid rgba(239,68,68,.2);">
                    <svg class="flex-shrink-0 mt-0.5" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <ul class="text-xs text-red-500 font-medium space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Session success (e.g. after password reset) --}}
            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-2xl flex items-center gap-2.5"
                     style="background:rgba(240,253,244,.85);border:1px solid rgba(34,197,94,.2);">
                    <svg class="flex-shrink-0" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <span class="text-xs text-green-600 font-medium">{{ session('status') }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-3" id="login-form">
                @csrf

                {{-- Email --}}
                <div class="field-1 relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </span>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Email address"
                        autocomplete="email"
                        inputmode="email"
                        value="{{ old('email') }}"
                        class="input-field w-full pl-9 pr-4 py-3 text-sm text-gray-700 placeholder-gray-400 @error('email') is-invalid @enderror"
                    />
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field-2 relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input
                        id="pw"
                        type="password"
                        name="password"
                        placeholder="Password"
                        autocomplete="current-password"
                        class="input-field w-full pl-9 pr-10 py-3 text-sm text-gray-700 placeholder-gray-400 @error('password') is-invalid @enderror"
                    />
                    <button type="button"
                            class="pw-toggle absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 -mr-1"
                            onclick="togglePw('pw','eye1')"
                            aria-label="Toggle password visibility">
                        <svg id="eye1" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me + Forgot password --}}
                <div class="field-3 flex items-center justify-between pt-0.5">
                    <div class="flex items-center gap-2 cursor-pointer" onclick="toggleRemember()">
                        <div id="toggle" class="toggle-track">
                            <div class="toggle-thumb"></div>
                        </div>
                        {{-- Hidden checkbox that gets submitted with the form --}}
                        <input type="checkbox" name="remember" id="remember" class="hidden"
                               {{ old('remember') ? 'checked' : '' }} />
                        <span class="text-xs text-gray-500 select-none">Remember me</span>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-blue-500 hover:underline font-medium">Forgot password?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="field-4">
                    <button
                        type="submit"
                        id="login-btn"
                        class="btn-primary w-full rounded-2xl py-3.5 text-white font-semibold text-sm tracking-wide touch-manipulation flex items-center justify-center gap-2">
                        <span id="btn-text">Sign In</span>
                        <svg id="btn-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        <svg id="btn-spinner" class="hidden animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        </svg>
                    </button>
                </div>

            </form>

            {{-- Register link --}}
            @if (Route::has('admin.register'))
            <p class="text-center text-xs text-gray-400 mt-5">
                Don't have an account?
                <a href="{{ route('admin.register') }}" class="text-blue-500 hover:underline font-medium ml-1">Create one</a>
            </p>
            @endif

        </div>
    </div>

    <script>
        /* Password toggle */
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            const icon = document.getElementById(iconId);
            icon.innerHTML = isText
                ? `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`
                : `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
        }

        /* Remember me toggle — syncs with hidden checkbox */
        let remembered = {{ old('remember') ? 'true' : 'false' }};
        const toggleEl   = document.getElementById('toggle');
        const rememberCb = document.getElementById('remember');

        // Reflect old() state on page load
        if (remembered) toggleEl.classList.add('on');

        function toggleRemember() {
            remembered = !remembered;
            toggleEl.classList.toggle('on', remembered);
            rememberCb.checked = remembered;
        }

        /* Loading spinner on submit */
        document.getElementById('login-form').addEventListener('submit', function () {
            const btn     = document.getElementById('login-btn');
            const text    = document.getElementById('btn-text');
            const arrow   = document.getElementById('btn-arrow');
            const spinner = document.getElementById('btn-spinner');
            btn.disabled      = true;
            text.textContent  = 'Signing in…';
            arrow.classList.add('hidden');
            spinner.classList.remove('hidden');
        });

        /* Shake button if server returned an error */
        @if ($errors->any() || session('error'))
            document.addEventListener('DOMContentLoaded', () => {
                const btn = document.getElementById('login-btn');
                btn.classList.add('shake');
                setTimeout(() => btn.classList.remove('shake'), 450);
            });
        @endif
    </script>
</body>
</html>