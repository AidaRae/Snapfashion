<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Register — {{ $settings['site_name'] ?? config('app.name') }} </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: 'DM Sans', sans-serif;
        }  

        h1,
        h2,
        h3,
        .display {
            font-family: 'Syne', sans-serif;
        }

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
        }

        @keyframes drift {
            from { transform: translateX(-120px); }
            to   { transform: translateX(calc(100vw + 120px)); }
        }

        .cloud-1 {
            width: 220px; height: 55px;
            bottom: 12%; left: -220px;
            animation: drift 28s linear infinite;
        }
        .cloud-2 {
            width: 300px; height: 70px;
            bottom: 6%; left: -300px;
            animation: drift 38s linear 6s infinite;
            opacity: 0.4;
        }
        .cloud-3 {
            width: 160px; height: 45px;
            bottom: 18%; left: -160px;
            animation: drift 22s linear 12s infinite;
            opacity: 0.5;
        }

        .orbit-arc {
            position: absolute;
            left: 50%; top: 50%;
            transform: translate(-50%, -30%);
            width: 700px; height: 700px;
            border-radius: 50%;
            border: 1.5px solid rgba(180,210,240,.5);
            pointer-events: none;
        }
        .orbit-arc-2 {
            width: 520px; height: 520px;
            border-color: rgba(180,210,240,.3);
        }

        @media (max-width: 480px) {
            .orbit-arc { display: none; }
        }

        .card {
            background: linear-gradient(145deg, rgba(255,255,255,.88) 0%, rgba(240,250,255,.82) 100%);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.7);
            box-shadow: 0 20px 60px rgba(100,160,210,.18), 0 2px 8px rgba(100,160,210,.1);
        }

        .icon-badge {
            background: linear-gradient(145deg, #ffffff, #e8f3fb);
            box-shadow: 0 4px 16px rgba(120,180,230,.2), inset 0 1px 0 rgba(255,255,255,.9);
        }

        .input-field {
            background: rgba(240,248,255,.7);
            border: 1.5px solid rgba(180,215,240,.5);
            border-radius: 12px;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(100,170,230,.12);
            background: rgba(255,255,255,.9);
        }
        .input-field.is-invalid {
            border-color: rgba(239,68,68,.5);
            background: rgba(254,242,242,.7);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 4px 18px rgba(20,30,70,.28);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(20,30,70,.36);
        }
        .btn-primary:active { transform: translateY(0); }

        .admin-badge {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(80,140,210,.08));
            border: 1px solid rgba(100,170,230,.3);
            border-radius: 20px;
            font-family: 'Syne', sans-serif;
            letter-spacing: .08em;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .card-wrap { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) both; }
        .topbar    { animation: fadeUp .4s cubic-bezier(.22,1,.36,1) both; }

        .pw-toggle { cursor: pointer; }

        .name-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        @media (max-width: 360px) {
            .name-grid { grid-template-columns: 1fr; }
        }

        .safe-bottom {
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

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

<body class="sky-bg flex flex-col items-center justify-center min-h-screen relative px-4 py-20 safe-bottom">

    {{-- Decorative clouds --}}
    <div class="cloud cloud-1"></div>
    <div class="cloud cloud-2"></div>
    <div class="cloud cloud-3"></div>

    {{-- Orbit arcs --}}
    <div class="orbit-arc"></div>
    <div class="orbit-arc orbit-arc-2"></div>

    {{-- Top bar --}}
    <div class="topbar fixed top-0 left-0 w-full flex items-center px-4 sm:px-8 py-3 sm:py-4 z-20"
         style="background: rgba(184,221,247,.45); backdrop-filter: blur(8px);">
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
    </div>

    {{-- Card --}}
    <div class="card-wrap relative z-10 w-full max-w-md">
        <div class="card rounded-3xl px-5 sm:px-8 pt-7 sm:pt-8 pb-6 sm:pb-7">

            {{-- Validation error summary --}}
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

            {{-- Icon --}}
            <div class="flex flex-col items-center mb-5">
                <div class="icon-badge w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mb-3 sm:mb-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1a1a2e" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/>
                        <line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                </div>

                <div class="admin-badge px-3 py-1 mb-2.5 sm:mb-3 flex items-center gap-1.5">
                    <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                    <span class="text-xs text-blue-600 font-semibold uppercase tracking-widest">Admin</span>
                </div>

                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight leading-tight text-center">
                    Create admin account
                </h1>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('admin.register') }}" class="space-y-3">
                @csrf

                {{-- Name row --}}
                <div class="name-grid">
                    {{-- First name --}}
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="first_name"
                            id="first_name"
                            placeholder="First name"
                            autocomplete="given-name"
                            value="{{ old('first_name') }}"
                            class="input-field w-full pl-9 pr-3 py-3 text-sm text-gray-700 placeholder-gray-400 @error('first_name') is-invalid @enderror"
                        />
                        @error('first_name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Last name --}}
                    <div class="relative">
                        <input
                            type="text"
                            name="last_name"
                            id="last_name"
                            placeholder="Last name"
                            autocomplete="family-name"
                            value="{{ old('last_name') }}"
                            class="input-field w-full px-3 py-3 text-sm text-gray-700 placeholder-gray-400 @error('last_name') is-invalid @enderror"
                        />
                        @error('last_name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="relative">
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
                <div class="relative">
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
                        autocomplete="new-password"
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

                {{-- Confirm Password --}}
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input
                        id="cpw"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                        autocomplete="new-password"
                        class="input-field w-full pl-9 pr-10 py-3 text-sm text-gray-700 placeholder-gray-400 @error('password_confirmation') is-invalid @enderror"
                    />
                    <button type="button"
                        class="pw-toggle absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 -mr-1"
                        onclick="togglePw('cpw','eye2')"
                        aria-label="Toggle confirm password visibility">
                        <svg id="eye2" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                    @error('password_confirmation')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Terms --}}
                <div class="flex items-start gap-2.5 pt-1">
                    <input
                        type="checkbox"
                        name="terms"
                        id="terms"
                        class="mt-0.5 w-4 h-4 rounded accent-blue-500 cursor-pointer flex-shrink-0 @error('terms') ring-1 ring-red-400 @enderror"
                        {{ old('terms') ? 'checked' : '' }}
                    />
                    <label for="terms" class="text-xs text-gray-500 leading-relaxed cursor-pointer">
                        I agree to the
                        <a href="#" class="text-blue-500 hover:underline font-medium">Terms of Service</a>
                        and
                        <a href="#" class="text-blue-500 hover:underline font-medium">Privacy Policy</a>.
                        Admin accounts are subject to additional
                        <a href="#" class="text-blue-500 hover:underline font-medium">guidelines</a>.
                    </label>
                </div>
                @error('terms')
                    <p class="error-message -mt-1">{{ $message }}</p>
                @enderror

                {{-- CTA --}}
                <button type="submit"
                    class="btn-primary w-full rounded-2xl py-3.5 text-white font-semibold text-sm tracking-wide mt-1 touch-manipulation">
                    Create Admin Account
                </button>

            </form>

            {{-- Sign in link --}}
            <p class="text-center text-xs text-gray-400 mt-5">
                Already have an account?
                <a href="{{ route('admin.login') }}" class="text-blue-500 hover:underline font-medium ml-1">Sign in</a>
            </p>

        </div>
    </div>

    <script>
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            const icon = document.getElementById(iconId);
            icon.innerHTML = isText
                ? `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`
                : `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
        }
    </script>
</body>
</html>