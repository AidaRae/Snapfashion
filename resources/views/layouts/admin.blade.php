<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(!empty($settings['description']))
        <meta name="description" content="{{ $settings['description'] }}">
    @endif
    @if(!empty($settings['keywords']))
        <meta name="keywords" content="{{ $settings['keywords'] }}">
    @endif
    <title>{{ $settings['site_name'] ?? config('app.name') }} | {{ $title ?? 'Dashboard' }}</title>
    @if(!empty($settings['favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset($settings['favicon']) }}" />
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Jost:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Jost', 'sans-serif'],
                        display: ['"Bodoni Moda"', 'serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#3b82f6',
                            light: '#3b82f6',
                            pale: 'rgba(59, 130, 246, 0.15)'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.15s ease;
        }

        body {
            font-family: 'Jost', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 99px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #374151;
        }

        .toggle-track {
            width: 40px;
            height: 22px;
            border-radius: 99px;
            position: relative;
            cursor: pointer;
            flex-shrink: 0;
        }

        .toggle-thumb {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            position: absolute;
            top: 3px;
            transition: left 0.2s ease;
        }

        .light .toggle-track {
            background: #e5e7eb;
        }

        .light .toggle-thumb {
            left: 3px;
            background: #6b7280;
        }

        .dark .toggle-track {
            background: #3b82f6;
        }

        .dark .toggle-thumb {
            left: 21px;
            background: #fff;
        }

        .nav-active {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            font-weight: 600;
        }

        .dark .nav-active {
            background: rgba(59, 130, 246, 0.18);
            color: #60a5fa;
        }

        .add-btn {
            background: #3b82f6;
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 2px 12px rgba(59, 130, 246, 0.3);
            white-space: nowrap;
        }

        .add-btn:hover {
            background: #3b82f6;
        }

        .status-badge {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        .row-hover:hover {
            background-color: rgba(59, 130, 246, 0.04);
        }

        .dark .row-hover:hover {
            background-color: rgba(59, 130, 246, 0.08);
        }

        .prod-img {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .page-num {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
        }

        .page-num.active {
            background: #3b82f6;
            color: #fff;
        }

        .page-num:not(.active):hover {
            background: #f3f4f6;
        }

        .dark .page-num:not(.active):hover {
            background: #374151;
        }

        input[type=checkbox] {
            accent-color: #3b82f6;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        #sidebar {
            transition: transform 0.28s cubic-bezier(.4, 0, .2, 1);
        }

        #sidebarOverlay {
            transition: opacity 0.28s ease;
        }

        #bottomNav {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .sort-icon {
            opacity: 0.4;
            margin-left: 3px;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-neutral-900 min-h-screen">

    <!-- Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-20 hidden opacity-0 lg:hidden" onclick="closeSidebar()">
    </div>
    @include('admin.include.aside_bar')


    <!-- MAIN -->
    <div class="lg:ml-60 flex flex-col min-h-screen pb-16 lg:pb-0">

        @include('admin.include.admin_header')

        <!-- Content -->
        @yield('admin')

        @include('admin.include.mobilenav')

        @include('admin.include.dashscript')

        @stack('scripts')
</body>

</html>
