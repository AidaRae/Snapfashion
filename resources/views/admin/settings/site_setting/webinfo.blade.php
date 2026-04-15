@extends('layouts.admin')

@section('admin')
    <style>
        .form-input {
            width: 100%;
            background: transparent;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 13.5px;
            color: #1f2937;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .dark .form-input {
            border-color: #374151;
            color: #f3f4f6;
            background: rgba(255, 255, 255, 0.03);
        }

        .dark .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .dark .form-input::placeholder {
            color: #6b7280;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 90px;
        }

        select.form-input {
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
        }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .dark .form-label {
            color: #9ca3af;
        }

        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .input-icon-wrap .icon-top {
            position: absolute;
            left: 13px;
            top: 13px;
            color: #9ca3af;
            pointer-events: none;
        }

        .input-icon-wrap input,
        .input-icon-wrap select,
        .input-icon-wrap textarea {
            padding-left: 38px !important;
        }

        .input-icon-wrap .chevron {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .file-drop {
            border: 1.5px dashed #d1d5db;
            border-radius: 14px;
            padding: 22px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            position: relative;
            text-align: center;
            transition: border-color 0.15s, background 0.15s;
        }

        .file-drop:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.03);
        }

        .dark .file-drop {
            border-color: #374151;
        }

        .dark .file-drop:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.06);
        }

        .file-drop input[type=file] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .file-drop-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dark .file-drop-icon {
            background: rgba(59, 130, 246, 0.18);
        }

        .preview-wrap {
            display: none;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            padding: 8px 12px;
            background: #f9fafb;
            border-radius: 10px;
            border: 1px solid #f0f0f0;
        }

        .dark .preview-wrap {
            background: rgba(255, 255, 255, 0.04);
            border-color: #404040;
        }

        .preview-wrap img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: contain;
            background: white;
            border: 1px solid #e5e7eb;
        }

        .settings-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            white-space: nowrap;
            color: #6b7280;
            transition: background 0.15s, color 0.15s;
        }

        .settings-tab-btn:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .settings-tab-btn.stab-active {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            font-weight: 600;
        }

        .dark .settings-tab-btn {
            color: #9ca3af;
        }

        .dark .settings-tab-btn:hover {
            background: rgba(24, 23, 23, 0.06);
            color: #e2e8f0;
        }

        .dark .settings-tab-btn.stab-active {
            background: rgba(59, 130, 246, 0.18);
            color: #60a5fa;
        }

        .section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .section-divider-line {
            flex: 1;
            height: 1px;
            background: #f0f0f0;
        }

        .dark .section-divider-line {
            background: #404040;
        }

        .section-divider-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9ca3af;
            white-space: nowrap;
        }

        .save-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #3b82f6;
            color: #fff;
            font-weight: 600;
            font-size: 13.5px;
            border-radius: 12px;
            padding: 11px 26px;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            box-shadow: 0 2px 14px rgba(59, 130, 246, 0.32);
            transition: background 0.15s, box-shadow 0.15s, transform 0.1s;
        }

        .save-btn:hover {
            background: #3b82f6;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.42);
        }

        .save-btn:active {
            transform: scale(0.98);
        }

        .reset-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: transparent;
            color: #6b7280;
            font-weight: 600;
            font-size: 13.5px;
            border-radius: 12px;
            padding: 11px 22px;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.15s, color 0.15s, border-color 0.15s;
        }

        .reset-btn:hover {
            background: #f9fafb;
            color: #374151;
        }

        .dark .reset-btn {
            border-color: #374151;
            color: #9ca3af;
        }

        .dark .reset-btn:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
        }

        /* Toast */
        #ws-toast {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Card */
        .s-card {
            background: #fff;
            border-radius: 20px;
            border: 1.5px solid #f0f0f0;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .dark .s-card {
            background: #262626;
            border-color: #404040;
            box-shadow: 0 1px 12px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-brand dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Website Settings</span>
        </div>

        {{-- Page heading --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
            <div>
                <h1 style="font-family:'Syne',sans-serif;font-weight:700;"
                    class="text-xl sm:text-2xl text-gray-800 dark:text-gray-100 tracking-tight leading-tight">
                    Website Settings
                </h1>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                    Configure your site's identity, SEO, branding and contact details.
                </p>
            </div>
            {{-- Live site pill --}}
            <a href="{{ route('shop.home') }}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 dark:border-neutral-700
                  text-sm font-medium text-gray-600 dark:text-gray-300
                  hover:bg-gray-50 dark:hover:bg-neutral-700 transition-colors self-start sm:self-auto">
                <span class="w-2 h-2 rounded-full bg-green-400 flex-shrink-0"></span>
                View live site
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                    <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

        {{-- Session Alerts --}}
        @if (session('success'))
            <div
                class="mb-5 flex items-center gap-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl px-4 py-3 text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div
                class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl px-4 py-3 text-sm">
                <p class="font-semibold mb-1">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Settings Card --}}
        <div class="s-card">

            {{-- Tab Bar --}}
            <div
                class="border-b border-gray-100 dark:border-neutral-700/80 px-4 sm:px-6 py-3
                    flex items-center gap-1 overflow-x-auto">
                <button class="settings-tab-btn stab-active" onclick="switchStab(this,'stab-general')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                        <path
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"
                            stroke="currentColor" stroke-width="2" />
                    </svg>
                    General
                </button>
                <button class="settings-tab-btn" onclick="switchStab(this,'stab-seo')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
                        <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    SEO
                </button>
                <button class="settings-tab-btn" onclick="switchStab(this,'stab-appearance')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"
                            stroke="currentColor" stroke-width="2" />
                    </svg>
                    Appearance
                </button>
                <button class="settings-tab-btn" onclick="switchStab(this,'stab-contact')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <path
                            d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.95 12a19.79 19.79 0 01-3.07-8.67A2 2 0 012.86 1h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L7.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Contact
                </button>
                <button class="settings-tab-btn" onclick="switchStab(this,'stab-shipping')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <path
                            d="M1 3h15v13H1zM16 8h4l3 4v5h-7V8zM5.5 21a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM18.5 21a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Shipping
                </button>
                <button class="settings-tab-btn" onclick="switchStab(this,'stab-banner')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <path d="M19 4H5a2 2 0 00-2 2v2a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2zM5 10v8a2 2 0 002 2h10a2 2 0 002-2v-8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 14h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Banner
                </button>
                <button class="settings-tab-btn" onclick="switchStab(this,'stab-homepage')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 9h18M9 21V9" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Homepage
                </button>

            </div>

            {{-- ══════════════════════════════════════════
             FORM — all tabs share one form / one submit
        ══════════════════════════════════════════ --}}
            <form action="{{ route('admin.settings.website.update') }}" method="POST" enctype="multipart/form-data"
                novalidate>
                @method('PUT')
                @csrf

                {{-- ── GENERAL TAB ── --}}
                <div id="stab-general" class="stab-content px-4 sm:px-6 lg:px-8 py-7">

                    <div class="section-divider">
                        <span class="section-divider-label">Basic Info</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Website Name --}}
                        <div>
                            <label class="form-label">Website Name</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="7" height="7" rx="1.5"
                                            fill="currentColor" opacity=".6" />
                                        <rect x="14" y="3" width="7" height="7" rx="1.5"
                                            fill="currentColor" />
                                        <rect x="3" y="14" width="7" height="7" rx="1.5"
                                            fill="currentColor" />
                                        <rect x="14" y="14" width="7" height="7" rx="1.5"
                                            fill="currentColor" opacity=".6" />
                                    </svg>
                                </span>
                                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"
                                    placeholder="My Awesome Site" class="form-input" required />
                            </div>
                            @error('site_name')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Website Title --}}
                        <div>
                            <label class="form-label">Website Title</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M4 6h16M4 12h10M4 18h7" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </span>
                                <input type="text" name="site_title" value="{{ $settings['site_title'] ?? '' }}"
                                    placeholder="Welcome to My Site" class="form-input" required />
                            </div>
                            @error('site_title')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Website URL --}}
                        <div>
                            <label class="form-label">Website URL</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="2" />
                                        <path
                                            d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"
                                            stroke="currentColor" stroke-width="2" />
                                    </svg>
                                </span>
                                <input type="text" name="site_address" value="{{ $settings['site_address'] ?? '' }}"
                                    placeholder="https://yoursite.com" class="form-input" required />
                            </div>
                            @error('site_address')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Timezone --}}
                        <div>
                            <label class="form-label">Timezone</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="2" />
                                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </span>
                                <select name="timezone" class="form-input">
                                    @foreach ($timezones as $list)
                                        <option value="{{ $list }}"
                                            {{ ($settings['timezone'] ?? '') === $list ? 'selected' : '' }}>
                                            {{ $list }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="chevron">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            @error('timezone')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="sm:col-span-2">
                            <label class="form-label">Website Description</label>
                            <div class="input-icon-wrap">
                                <span class="icon-top">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        <polyline points="14 2 14 8 20 8" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                        <line x1="16" y1="13" x2="8" y2="13"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        <line x1="16" y1="17" x2="8" y2="17"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                </span>
                                <textarea name="description" rows="3" placeholder="Describe your website briefly…" class="form-input">{{ $settings['description'] ?? '' }}</textarea>
                            </div>
                            @error('description')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ── SEO TAB ── --}}
                <div id="stab-seo" class="stab-content hidden px-4 sm:px-6 lg:px-8 py-7">

                    <div class="section-divider">
                        <span class="section-divider-label">Search Engine Optimisation</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Keywords --}}
                        <div class="sm:col-span-2">
                            <label class="form-label">Meta Keywords</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path
                                            d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <line x1="7" y1="7" x2="7.01" y2="7"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                </span>
                                <input type="text" name="keywords" value="{{ $settings['keywords'] ?? '' }}"
                                    placeholder="fashion, clothing, style, trends" class="form-input" required />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">
                                Separate keywords with commas.
                            </p>
                            @error('keywords')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Meta Author --}}
                        <div>
                            <label class="form-label">Meta Author</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <input type="text" name="meta_author" value="{{ $settings['meta_author'] ?? '' }}"
                                    placeholder="e.g. John Doe / Snapfashion" class="form-input" />
                            </div>
                        </div>

                        {{-- Google Analytics --}}
                        <div>
                            <label class="form-label">Google Analytics (Measurement ID)</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M18 20V10M12 20V4M6 20v-4" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <input type="text" name="google_analytics"
                                    value="{{ $settings['google_analytics'] ?? '' }}" placeholder="G-XXXXXXXXXX"
                                    class="form-input" />
                            </div>
                        </div>

                        {{-- Facebook Pixel --}}
                        <div>
                            <label class="form-label">Facebook Pixel ID</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <input type="text" name="facebook_pixel"
                                    value="{{ $settings['facebook_pixel'] ?? '' }}" placeholder="xxxxxxxxxxxxxxx"
                                    class="form-input" />
                            </div>
                        </div>

                        {{-- Custom Header Code --}}
                        <div class="sm:col-span-2">
                            <label class="form-label">Custom Header Scripts (e.g. Meta verification tags)</label>
                            <div class="input-icon-wrap">
                                <span class="icon-top">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M16 18l6-6-6-6M8 6l-6 6 6 6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <textarea name="custom_header_code" rows="4"
                                    placeholder="<meta name='google-site-verification' content='...' />" class="form-input font-mono text-xs">{{ $settings['custom_header_code'] ?? '' }}</textarea>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">
                                These tags will be injected directly into the <code>&lt;head&gt;</code> of your website.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- ── APPEARANCE TAB ── --}}
                <div id="stab-appearance" class="stab-content hidden px-4 sm:px-6 lg:px-8 py-7">

                    <div class="section-divider">
                        <span class="section-divider-label">Branding Assets</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        {{-- Logo --}}
                        <div>
                            <label class="form-label">
                                Logo
                                <span class="normal-case font-normal text-gray-400 dark:text-gray-600 ml-1">
                                    — max 200×100px
                                </span>
                            </label>
                            <div class="file-drop" id="logoDrop">
                                <input type="file" name="logo" accept="image/*"
                                    onchange="handleFilePick(this,'logoPreviewWrap','logoPreviewImg','logoFileName')">
                                <div class="file-drop-icon">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                        class="text-brand">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"
                                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Click to upload logo
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    PNG, JPG, SVG, WEBP
                                </p>
                            </div>
                            {{-- Preview --}}
                            <div id="logoPreviewWrap" class="preview-wrap mt-2" style="display:none;">
                                <img id="logoPreviewImg" src="" alt="Logo preview" />
                                <div class="min-w-0">
                                    <p id="logoFileName"
                                        class="text-xs font-semibold text-gray-700 dark:text-gray-200 truncate"></p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Selected</p>
                                </div>
                                <button type="button" onclick="clearFile('logo','logoPreviewWrap')"
                                    class="ml-auto text-gray-400 hover:text-red-500 transition-colors flex-shrink-0">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                            {{-- Show existing --}}
                            @if (!empty($settings['logo']))
                                <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 dark:text-gray-500">
                                    <img src="{{ asset($settings['logo']) }}" alt="Current logo"
                                        class="w-8 h-8 rounded object-contain border border-gray-200 dark:border-neutral-700 bg-white" />
                                    <span>Current logo</span>
                                </div>
                            @endif
                        </div>

                        {{-- Favicon --}}
                        <div>
                            <label class="form-label">
                                Favicon
                                <span class="normal-case font-normal text-gray-400 dark:text-gray-600 ml-1">
                                    — PNG, 32×32px
                                </span>
                            </label>
                            <div class="file-drop" id="faviconDrop">
                                <input type="file" name="favicon" accept="image/*"
                                    onchange="handleFilePick(this,'faviconPreviewWrap','faviconPreviewImg','faviconFileName')">
                                <div class="file-drop-icon">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                        class="text-brand">
                                        <rect x="3" y="3" width="18" height="18" rx="3"
                                            stroke="currentColor" stroke-width="1.8" />
                                        <path d="M9 9h6M9 12h4M9 15h5" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Click to upload favicon
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    PNG recommended · 32×32px
                                </p>
                            </div>
                            <div id="faviconPreviewWrap" class="preview-wrap mt-2" style="display:none;">
                                <img id="faviconPreviewImg" src="" alt="Favicon preview" />
                                <div class="min-w-0">
                                    <p id="faviconFileName"
                                        class="text-xs font-semibold text-gray-700 dark:text-gray-200 truncate"></p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Selected</p>
                                </div>
                                <button type="button" onclick="clearFile('favicon','faviconPreviewWrap')"
                                    class="ml-auto text-gray-400 hover:text-red-500 transition-colors flex-shrink-0">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                            @if (!empty($settings['favicon']))
                                <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 dark:text-gray-500">
                                    <img src="{{ asset($settings['favicon']) }}" alt="Current favicon"
                                        class="w-8 h-8 rounded object-contain border border-gray-200 dark:border-neutral-700 bg-white" />
                                    <span>Current favicon</span>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- ── CONTACT TAB ── --}}
                <div id="stab-contact" class="stab-content hidden px-4 sm:px-6 lg:px-8 py-7">

                    <div class="section-divider">
                        <span class="section-divider-label">Contact Details</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- WhatsApp --}}
                        <div>
                            <label class="form-label">Phone Number</label>
                            <div class="input-icon-wrap">
                                <span class="icon" style="color:#25d366;">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path
                                            d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <input type="text" name="phone_num" value="{{ $settings['phone_num'] ?? '' }}"
                                    placeholder="+1 234 567 8900" class="form-input" />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">
                                Include country code — e.g. +234 801 234 5678
                            </p>
                            @error('phone_num')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- INSTAGRAM --}}
                        <div>
                            <label class="form-label" for="instagram">Instagram</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <rect x="2" y="2" width="20" height="20" rx="5"
                                            stroke="currentColor" stroke-width="2" />
                                        <circle cx="12" cy="12" r="4" stroke="currentColor"
                                            stroke-width="2" />
                                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" />
                                    </svg>
                                </span>
                                <input type="text" name="contact_instagram" id="instagram" class="form-input"
                                    value="{{ $settings['contact_instagram'] ?? '' }}"
                                    placeholder="https://instagram.com/yourhandle" />
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── HOMEPAGE TAB ── --}}
                <div id="stab-homepage" class="stab-content hidden px-4 sm:px-6 lg:px-8 py-7">
                    <div class="section-divider">
                        <span class="section-divider-label">Homepage Sliders</span>
                        <div class="section-divider-line"></div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Upload up to 5 images for the main auto-scrolling hero slider on your homepage. The slides will display in the exact order you provide them. We recommend 1920x1080 (or similar aspect ratio) for standard fullscreen display.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="card p-4 border border-gray-100 dark:border-neutral-800 bg-white/50 dark:bg-neutral-900/50 rounded-2xl relative">
                                <label class="form-label space-x-2">
                                    <span>Slide {{ $i }}</span>
                                </label>

                                <div class="file-drop" id="slide{{ $i }}Drop">
                                    <input type="file" name="home_slide_{{ $i }}" accept="image/*"
                                        onchange="handleFilePick(this,'slide{{ $i }}PreviewWrap','slide{{ $i }}PreviewImg','slide{{ $i }}FileName')">
                                    <div class="file-drop-icon">
                                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" class="text-brand">
                                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 mt-2">Click to upload Slide {{ $i }}</p>
                                </div>

                                <div id="slide{{ $i }}PreviewWrap" class="preview-wrap mt-2" style="display:none;">
                                    <img id="slide{{ $i }}PreviewImg" src="" alt="Slide {{ $i }} preview" class="w-12 h-12 object-cover rounded" />
                                    <div class="min-w-0">
                                        <p id="slide{{ $i }}FileName" class="text-xs font-semibold text-gray-700 dark:text-gray-200 truncate"></p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">Selected</p>
                                    </div>
                                    <button type="button" onclick="clearFile('home_slide_{{ $i }}','slide{{ $i }}PreviewWrap')" class="ml-auto text-gray-400 hover:text-red-500 transition-colors flex-shrink-0">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    </button>
                                </div>

                                @if (!empty($settings['home_slide_' . $i]))
                                    <div class="flex items-center gap-3 mt-3 p-2 bg-gray-50 dark:bg-neutral-800 rounded-lg border border-gray-100 dark:border-neutral-700">
                                        <img src="{{ asset('storage/' . $settings['home_slide_' . $i]) }}" alt="Current Slide {{ $i }}"
                                            class="w-12 h-12 rounded object-cover" />
                                        <span class="text-xs text-gray-500 font-medium">Currently Active</span>
                                        <label class="ml-auto flex items-center gap-2 cursor-pointer text-xs text-red-500 hover:text-red-600 font-medium px-2 py-1 bg-red-50 dark:bg-red-500/10 rounded transition-colors">
                                            <input type="checkbox" name="remove_home_slide_{{ $i }}" value="1" class="w-3.5 h-3.5 rounded text-red-500 border-red-300 focus:ring-red-500 bg-white">
                                            Remove
                                        </label>
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- ── BANNER TAB ── --}}
                <div id="stab-banner" class="stab-content hidden px-4 sm:px-6 lg:px-8 py-7">

                    <div class="section-divider">
                        <span class="section-divider-label">Homepage Sales Banner</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Configure the promotional banner that appears on your homepage between the products section and newsletter. Great for sales, collections, and seasonal offers.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">

                        {{-- Enable Banner --}}
                        <div class="sm:col-span-2">
                            <label class="flex items-center gap-3 cursor-pointer select-none">
                                <input type="hidden" name="banner_enabled" value="0">
                                <input type="checkbox" name="banner_enabled" value="1"
                                    {{ ($settings['banner_enabled'] ?? '0') == '1' ? 'checked' : '' }}
                                    class="w-5 h-5 rounded border-gray-300 dark:border-neutral-600 text-blue-500 focus:ring-blue-500 cursor-pointer">
                                <div>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">Enable Sales Banner</span>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">When enabled, the banner section appears on the homepage.</p>
                                </div>
                            </label>
                        </div>

                        {{-- Banner Tag --}}
                        <div>
                            <label class="form-label">Tag Line</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <line x1="7" y1="7" x2="7.01" y2="7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input type="text" name="banner_tag" value="{{ $settings['banner_tag'] ?? '' }}"
                                    placeholder="e.g. Limited Time" class="form-input" maxlength="50" />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Small text above the title (optional).</p>
                        </div>

                        {{-- Banner Title --}}
                        <div>
                            <label class="form-label">Banner Title</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M4 6h16M4 12h10M4 18h7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input type="text" name="banner_title" value="{{ $settings['banner_title'] ?? '' }}"
                                    placeholder="e.g. Up to 40% Off Selected Pieces" class="form-input" maxlength="120" />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Main heading. Use a new line for line breaks.</p>
                        </div>

                        {{-- Banner Subtitle --}}
                        <div class="sm:col-span-2">
                            <label class="form-label">Subtitle</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <polyline points="14 2 14 8 20 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <input type="text" name="banner_subtitle" value="{{ $settings['banner_subtitle'] ?? '' }}"
                                    placeholder="e.g. Ends April 15th — no code needed." class="form-input" maxlength="200" />
                            </div>
                        </div>

                        {{-- Button Text --}}
                        <div>
                            <label class="form-label">Button Text</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <rect x="3" y="8" width="18" height="8" rx="3" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </span>
                                <input type="text" name="banner_button_text" value="{{ $settings['banner_button_text'] ?? '' }}"
                                    placeholder="e.g. Shop the Sale" class="form-input" maxlength="40" />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Leave empty to hide the button.</p>
                        </div>

                        {{-- Button Link --}}
                        <div>
                            <label class="form-label">Button Link</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <input type="text" name="banner_link" value="{{ $settings['banner_link'] ?? '' }}"
                                    placeholder="/shop or https://..." class="form-input" />
                            </div>
                        </div>

                        {{-- Banner Image --}}
                        <div class="sm:col-span-2">
                            <label class="form-label">
                                Background Image
                                <span class="normal-case font-normal text-gray-400 dark:text-gray-600 ml-1">— recommended 1200×400px</span>
                            </label>
                            <div class="file-drop" id="bannerDrop">
                                <input type="file" name="banner_image" accept="image/*"
                                    onchange="handleFilePick(this,'bannerPreviewWrap','bannerPreviewImg','bannerFileName')">
                                <div class="file-drop-icon">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" class="text-brand">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">Click to upload banner image</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">JPG, PNG, WEBP · Max 2MB</p>
                            </div>
                            <div id="bannerPreviewWrap" class="preview-wrap mt-2" style="display:none;">
                                <img id="bannerPreviewImg" src="" alt="Banner preview" />
                                <div class="min-w-0">
                                    <p id="bannerFileName" class="text-xs font-semibold text-gray-700 dark:text-gray-200 truncate"></p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">Selected</p>
                                </div>
                                <button type="button" onclick="clearFile('banner_image','bannerPreviewWrap')" class="ml-auto text-gray-400 hover:text-red-500 transition-colors flex-shrink-0">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                </button>
                            </div>
                            @if(!empty($settings['banner_image']))
                                <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 dark:text-gray-500">
                                    <img src="{{ asset('storage/' . $settings['banner_image']) }}" alt="Current banner"
                                        class="w-16 h-8 rounded object-cover border border-gray-200 dark:border-neutral-700" />
                                    <span>Current banner image</span>
                                </div>
                            @endif
                        </div>

                        {{-- Background Color --}}
                        <div>
                            <label class="form-label">Background Color (fallback)</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="banner_bg_color" value="{{ $settings['banner_bg_color'] ?? '#2C2218' }}"
                                    class="w-10 h-10 rounded-lg border border-gray-200 dark:border-neutral-700 cursor-pointer p-0.5" id="bannerBgColorPicker">
                                <input type="text" value="{{ $settings['banner_bg_color'] ?? '#2C2218' }}"
                                    class="form-input flex-1 font-mono text-xs uppercase" id="bannerBgColorText" maxlength="7"
                                    oninput="document.getElementById('bannerBgColorPicker').value=this.value">
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Used as the banner background. Image overlays this color.</p>
                        </div>

                        {{-- Text Color --}}
                        <div>
                            <label class="form-label">Title Text Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="banner_text_color" value="{{ $settings['banner_text_color'] ?? '#F7F3EE' }}"
                                    class="w-10 h-10 rounded-lg border border-gray-200 dark:border-neutral-700 cursor-pointer p-0.5" id="bannerTextColorPicker">
                                <input type="text" value="{{ $settings['banner_text_color'] ?? '#F7F3EE' }}"
                                    class="form-input flex-1 font-mono text-xs uppercase" id="bannerTextColorText" maxlength="7"
                                    oninput="document.getElementById('bannerTextColorPicker').value=this.value">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── SHIPPING TAB ── --}}
                <div id="stab-shipping" class="stab-content hidden px-4 sm:px-6 lg:px-8 py-7">

                    {{-- General Shipping --}}
                    <div class="section-divider">
                        <span class="section-divider-label">General Shipping</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">

                        {{-- Free Shipping Threshold --}}
                        <div>
                            <label class="form-label">Free Shipping Threshold (₦)</label>
                            <div class="input-icon-wrap">
                                <span class="icon" style="font-weight:700;font-size:13px;color:#9ca3af;">₦</span>
                                <input type="number" name="free_shipping_threshold" min="0" step="100"
                                    value="{{ old('free_shipping_threshold', $shipping['free_shipping_threshold'] ?? 15000) }}"
                                    class="form-input" />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Orders above this amount
                                qualify for free shipping. Set 0 to disable.</p>
                        </div>

                        {{-- Default Delivery Estimate --}}
                        <div>
                            <label class="form-label">Default Delivery Estimate</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="2" />
                                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </span>
                                <input type="text" name="default_delivery_estimate"
                                    value="{{ old('default_delivery_estimate', $shipping['default_delivery_estimate'] ?? '3 - 5 business days') }}"
                                    placeholder="e.g. 3 - 5 business days" class="form-input" />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Shown to customers at checkout
                                if no zone match.</p>
                        </div>

                        {{-- Shipping Origin State --}}
                        <div>
                            <label class="form-label">Shipping Origin State</label>
                            <div class="input-icon-wrap">
                                <span class="icon">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1118 0z" stroke="currentColor"
                                            stroke-width="2" />
                                        <circle cx="12" cy="10" r="3" stroke="currentColor"
                                            stroke-width="2" />
                                    </svg>
                                </span>
                                <select name="origin_state" class="form-input">
                                    @php
                                        $nigeriaStates = [
                                            'Abia',
                                            'Adamawa',
                                            'Akwa Ibom',
                                            'Anambra',
                                            'Bauchi',
                                            'Bayelsa',
                                            'Benue',
                                            'Borno',
                                            'Cross River',
                                            'Delta',
                                            'Ebonyi',
                                            'Edo',
                                            'Ekiti',
                                            'Enugu',
                                            'FCT - Abuja',
                                            'Gombe',
                                            'Imo',
                                            'Jigawa',
                                            'Kaduna',
                                            'Kano',
                                            'Katsina',
                                            'Kebbi',
                                            'Kogi',
                                            'Kwara',
                                            'Lagos',
                                            'Nasarawa',
                                            'Niger',
                                            'Ogun',
                                            'Ondo',
                                            'Osun',
                                            'Oyo',
                                            'Plateau',
                                            'Rivers',
                                            'Sokoto',
                                            'Taraba',
                                            'Yobe',
                                            'Zamfara',
                                        ];
                                        $currentOrigin = old('origin_state', $shipping['origin_state'] ?? 'Lagos');
                                    @endphp
                                    @foreach ($nigeriaStates as $state)
                                        <option value="{{ $state }}"
                                            class="bg-white text-gray-900 dark:bg-neutral-800 dark:text-gray-100"
                                            @selected($currentOrigin === $state)>
                                            {{ $state }}</option>
                                    @endforeach
                                </select>
                                <span class="chevron">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Your warehouse / dispatch
                                location.</p>
                        </div>


                    </div>

                    {{-- Shipping Zones --}}
                    <div class="section-divider">
                        <span class="section-divider-label">Shipping Zones & Rates</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div
                        class="mb-5 flex items-center justify-between bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 p-4 rounded-xl shadow-sm">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Enable Shipping Processing
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Turn off to completely disable
                                shipping options globally at checkout.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_enabled" value="1" class="sr-only peer"
                                {{ $shipping['is_enabled'] ?? true ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-500">
                            </div>
                        </label>
                    </div>

                    <div
                        class="mb-5 flex flex-col sm:flex-row items-center justify-between bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 p-4 rounded-xl shadow-sm">
                        <div class="w-full sm:w-auto mb-3 sm:mb-0">
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Enable Flat Rate Shipping
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">If enabled, standard shipping zones
                                below will be ignored and all standard shipping will cost this flat amount.</p>
                        </div>
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="flex flex-col">
                                <label class="text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1">Flat
                                    Rate (₦)</label>
                                <input type="number" name="flat_rate_price"
                                    value="{{ old('flat_rate_price', $shipping['flat_rate_price'] ?? 0) }}"
                                    class="form-input w-24 text-sm px-2 py-1" />
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer mt-4">
                                <input type="checkbox" name="is_flat_rate_enabled" value="1" class="sr-only peer"
                                    {{ $shipping['is_flat_rate_enabled'] ?? false ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-500">
                                </div>
                            </label>
                        </div>
                    </div>

                    <div
                        class="mb-5 flex items-center justify-between bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 p-4 rounded-xl shadow-sm">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Offer Global Free Shipping
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">If enabled, standard zone rates and
                                flat rates will be bypassed, and shipping will be unconditionally free for all orders.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_free_shipping_enabled" value="1" class="sr-only peer"
                                {{ $shipping['is_free_shipping_enabled'] ?? false ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-500">
                            </div>
                        </label>
                    </div>

                    <div class="mb-3 flex items-center justify-end">
                        <button type="button" onclick="addZoneRow()" class="save-btn"
                            style="padding:8px 14px;font-size:12px;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" />
                            </svg>
                            Add Zone
                        </button>
                    </div>

                    {{-- Zone table header --}}
                    <div
                        class="hidden sm:grid grid-cols-12 gap-3 px-3 py-2.5 rounded-t-xl bg-gray-50 dark:bg-neutral-700/40 border border-gray-200 dark:border-neutral-600 text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                        <div class="col-span-3">Zone Name</div>
                        <div class="col-span-4">States Covered</div>
                        <div class="col-span-2">Rate (₦)</div>
                        <div class="col-span-2">Delivery Days</div>
                        <div class="col-span-1 text-right">Del</div>
                    </div>

                    <div id="zonesContainer"
                        class="border border-t-0 border-gray-200 dark:border-neutral-600 rounded-b-xl divide-y divide-gray-100 dark:divide-neutral-700 mb-6">
                        @php
                            $defaultZones = [
                                ['name' => 'Lagos Same-Day', 'states' => 'Lagos', 'rate' => 1500, 'days' => '1 - 2'],
                                [
                                    'name' => 'South-West',
                                    'states' => 'Ogun, Oyo, Osun, Ondo, Ekiti',
                                    'rate' => 2500,
                                    'days' => '2 - 3',
                                ],
                                [
                                    'name' => 'South-South',
                                    'states' => 'Rivers, Delta, Edo, Bayelsa, Cross River, Akwa Ibom',
                                    'rate' => 3000,
                                    'days' => '3 - 5',
                                ],
                                [
                                    'name' => 'South-East',
                                    'states' => 'Anambra, Imo, Enugu, Abia, Ebonyi',
                                    'rate' => 3000,
                                    'days' => '3 - 5',
                                ],
                                [
                                    'name' => 'North-Central',
                                    'states' => 'FCT - Abuja, Kogi, Benue, Nasarawa, Niger, Plateau, Kwara',
                                    'rate' => 3500,
                                    'days' => '4 - 6',
                                ],
                                [
                                    'name' => 'North-West',
                                    'states' => 'Kano, Kaduna, Katsina, Jigawa, Kebbi, Sokoto, Zamfara',
                                    'rate' => 4000,
                                    'days' => '5 - 7',
                                ],
                                [
                                    'name' => 'North-East',
                                    'states' => 'Borno, Yobe, Adamawa, Gombe, Bauchi, Taraba',
                                    'rate' => 4500,
                                    'days' => '5 - 7',
                                ],
                            ];
                            $zones = old('zones', $shipping['zones'] ?? $defaultZones);
                        @endphp

                        @foreach ($zones as $i => $zone)
                            <div class="zone-row grid grid-cols-12 gap-3 px-3 py-3 items-start"
                                data-index="{{ $i }}">
                                <div class="col-span-12 sm:col-span-3">
                                    <label
                                        class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1 block">Zone
                                        Name</label>
                                    <input type="text" name="zones[{{ $i }}][name]"
                                        value="{{ $zone['name'] }}" placeholder="Zone name" class="form-input" />
                                </div>
                                <div class="col-span-12 sm:col-span-4">
                                    <label
                                        class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1 block">States</label>
                                    <input type="text" name="zones[{{ $i }}][states]"
                                        value="{{ $zone['states'] }}" placeholder="Lagos, Ogun, ..."
                                        class="form-input" />
                                </div>
                                <div class="col-span-5 sm:col-span-2">
                                    <label
                                        class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1 block">Rate
                                        (₦)
                                    </label>
                                    <input type="number" name="zones[{{ $i }}][rate]" min="0"
                                        step="50" value="{{ $zone['rate'] }}" class="form-input" />
                                </div>
                                <div class="col-span-5 sm:col-span-2">
                                    <label
                                        class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1 block">Days</label>
                                    <input type="text" name="zones[{{ $i }}][days]"
                                        value="{{ $zone['days'] }}" placeholder="3 - 5" class="form-input" />
                                </div>
                                <div class="col-span-2 sm:col-span-1 flex items-center justify-end pt-1">
                                    <button type="button" onclick="removeZoneRow(this)"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                                            <path
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="zonesEmpty" class="{{ count($zones) > 0 ? 'hidden' : '' }} px-5 py-8 text-center mb-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No shipping zones yet. Click <strong>Add
                                Zone</strong> to get started.</p>
                    </div>


                    {{-- Special Conditions --}}
                    <div class="section-divider">
                        <span class="section-divider-label">Special Conditions</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Remote Area Surcharge (₦)</label>
                            <div class="input-icon-wrap">
                                <span class="icon" style="font-weight:700;font-size:13px;color:#9ca3af;">₦</span>
                                <input type="number" name="remote_area_surcharge" min="0" step="50"
                                    value="{{ old('remote_area_surcharge', $shipping['remote_area_surcharge'] ?? 1000) }}"
                                    class="form-input" />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Added to delivery fee for
                                hard-to-reach locations.</p>
                        </div>

                        <div>
                            <label class="form-label">Bulky Item Surcharge (₦)</label>
                            <div class="input-icon-wrap">
                                <span class="icon" style="font-weight:700;font-size:13px;color:#9ca3af;">₦</span>
                                <input type="number" name="bulky_surcharge" min="0" step="50"
                                    value="{{ old('bulky_surcharge', $shipping['bulky_surcharge'] ?? 2000) }}"
                                    class="form-input" />
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Extra fee for oversized or
                                heavy products.</p>
                        </div>

                        <div>
                            <label class="form-label">Bulky Weight Threshold (kg)</label>
                            <input type="number" name="bulky_weight_kg" min="0" step="0.5"
                                value="{{ old('bulky_weight_kg', $shipping['bulky_weight_kg'] ?? 10) }}"
                                class="form-input" />
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Orders above this weight are
                                flagged as bulky.</p>
                        </div>

                        <div>
                            <label class="form-label">Holiday / Delay Notice</label>
                            <input type="text" name="holiday_notice"
                                value="{{ old('holiday_notice', $shipping['holiday_notice'] ?? '') }}"
                                placeholder="e.g. Deliveries may be delayed due to public holidays" class="form-input" />
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5 ml-1">Displayed at checkout when
                                active. Leave blank to hide.</p>
                        </div>
                    </div>

                </div>



                {{-- ── FORM FOOTER ── --}}
                <div
                    class="px-4 sm:px-6 lg:px-8 py-5
                        border-t border-gray-100 dark:border-neutral-700/80
                        flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 hidden sm:block">
                        Changes are applied immediately after saving.
                    </p>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="reset" class="reset-btn flex-1 sm:flex-none justify-center">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                                <path d="M3 12a9 9 0 109-9 9.75 9.75 0 00-6.74 2.74L3 8" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <polyline points="3 3 3 8 8 8" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Reset
                        </button>
                        <button type="submit" class="save-btn flex-1 sm:flex-none justify-center">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <polyline points="17 21 17 13 7 13 7 21" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                                <polyline points="7 3 7 8 15 8" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            Update Settings
                        </button>
                    </div>
                </div>

            </form>
        </div>{{-- /s-card --}}

    </div>{{-- /page padding --}}

    {{-- Toast notification --}}
    <div id="ws-toast" class="fixed top-5 right-5 z-50 opacity-0 translate-y-2 pointer-events-none"
        style="transition: opacity 0.3s ease, transform 0.3s ease;">
        <div
            class="flex items-center gap-3 bg-white dark:bg-neutral-800
                border border-gray-100 dark:border-neutral-700
                rounded-2xl px-4 py-3 shadow-2xl min-w-[260px]">
            <div
                class="w-9 h-9 rounded-full bg-green-100 dark:bg-green-900/40
                    flex items-center justify-center flex-shrink-0">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <path d="M20 6L9 17l-5-5" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Settings updated!</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Your changes have been saved successfully.</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // ── Tab switching ──
            function switchStab(btn, id) {
                document.querySelectorAll('.settings-tab-btn').forEach(b => b.classList.remove('stab-active'));
                document.querySelectorAll('.stab-content').forEach(t => t.classList.add('hidden'));
                btn.classList.add('stab-active');
                document.getElementById(id).classList.remove('hidden');
            }

            // ── File picker ──
            function handleFilePick(input, wrapId, imgId, nameId) {
                const file = input.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById(imgId).src = e.target.result;
                    document.getElementById(nameId).textContent = file.name;
                    const wrap = document.getElementById(wrapId);
                    wrap.style.display = 'flex';
                };
                reader.readAsDataURL(file);
            }

            function clearFile(inputName, wrapId) {
                // Clear the file input
                const form = document.querySelector('form');
                const input = form.querySelector(`input[name="${inputName}"]`);
                if (input) input.value = '';
                document.getElementById(wrapId).style.display = 'none';
            }

            // ── Success toast (on flash session) ──
            @if (session('success'))
                window.addEventListener('DOMContentLoaded', () => showWsToast());
            @endif

            function showWsToast() {
                const t = document.getElementById('ws-toast');
                t.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
                t.classList.add('opacity-100', 'translate-y-0');
                setTimeout(() => {
                    t.classList.remove('opacity-100', 'translate-y-0');
                    t.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
                }, 3500);
            }

            // ── Validation error tab: auto-switch to the tab that has errors ──
            (function() {
                const errorFields = {
                    stab_general: ['site_name', 'site_title', 'site_address', 'timezone', 'description'],
                    stab_seo: ['keywords'],
                    stab_contact: ['phone_num'],
                    stab_shipping: ['free_shipping_threshold', 'default_delivery_estimate', 'origin_state',
                        'remote_area_surcharge', 'bulky_surcharge', 'bulky_weight_kg'
                    ],
                    stab_banner: ['banner_title', 'banner_tag', 'banner_subtitle', 'banner_button_text', 'banner_link', 'banner_image']
                };
                @if ($errors->any())
                    const errKeys = @json($errors->keys());
                    for (const [tab, fields] of Object.entries(errorFields)) {
                        if (fields.some(f => errKeys.includes(f))) {
                            const btn = document.querySelector(`.settings-tab-btn[onclick*="${tab.replace('_','-')}"]`);
                            if (btn) switchStab(btn, tab.replace('_', '-'));
                            break;
                        }
                    }
                @endif
            })();

            // ── Shipping tab: Zone add/remove ──
            let zoneIndex = {{ count($zones ?? []) }};

            window.addZoneRow = function() {
                const container = document.getElementById('zonesContainer');
                const empty = document.getElementById('zonesEmpty');
                const i = zoneIndex++;
                const row = document.createElement('div');
                row.className = 'zone-row grid grid-cols-12 gap-3 px-3 py-3 items-start';
                row.dataset.index = i;
                row.innerHTML = `
                    <div class="col-span-12 sm:col-span-3">
                        <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1 block">Zone Name</label>
                        <input type="text" name="zones[${i}][name]" placeholder="Zone name" class="form-input" />
                    </div>
                    <div class="col-span-12 sm:col-span-4">
                        <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1 block">States</label>
                        <input type="text" name="zones[${i}][states]" placeholder="Lagos, Ogun, ..." class="form-input" />
                    </div>
                    <div class="col-span-5 sm:col-span-2">
                        <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1 block">Rate (₦)</label>
                        <input type="number" name="zones[${i}][rate]" min="0" step="50" placeholder="0" class="form-input" />
                    </div>
                    <div class="col-span-5 sm:col-span-2">
                        <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 mb-1 block">Days</label>
                        <input type="text" name="zones[${i}][days]" placeholder="3 - 5" class="form-input" />
                    </div>
                    <div class="col-span-2 sm:col-span-1 flex items-center justify-end pt-1">
                        <button type="button" onclick="removeZoneRow(this)" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                `;
                row.style.opacity = '0';
                row.style.transform = 'translateY(-6px)';
                container.appendChild(row);
                empty.classList.add('hidden');
                requestAnimationFrame(() => {
                    row.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                });
                row.querySelector('input[type=text]').focus();
            }

            window.removeZoneRow = function(btn) {
                const row = btn.closest('.zone-row');
                row.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(8px)';
                setTimeout(() => {
                    row.remove();
                    if (document.getElementById('zonesContainer').querySelectorAll('.zone-row').length === 0) {
                        document.getElementById('zonesEmpty').classList.remove('hidden');
                    }
                }, 150);
            }

            // Courier checkbox highlight toggle
            document.querySelectorAll('.courier-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    const label = document.getElementById(this.dataset.label);
                    if (this.checked) {
                        label.classList.remove('border-gray-200', 'dark:border-neutral-700');
                        label.classList.add('border-brand', 'bg-brand-pale/50', 'dark:bg-brand/10',
                            'dark:border-brand/40');
                    } else {
                        label.classList.add('border-gray-200', 'dark:border-neutral-700');
                        label.classList.remove('border-brand', 'bg-brand-pale/50', 'dark:bg-brand/10',
                            'dark:border-brand/40');
                    }
                });
            });

            // ── Banner tab: color picker sync ──
            const bgPicker = document.getElementById('bannerBgColorPicker');
            const bgText = document.getElementById('bannerBgColorText');
            const txtPicker = document.getElementById('bannerTextColorPicker');
            const txtText = document.getElementById('bannerTextColorText');

            if (bgPicker) {
                bgPicker.addEventListener('input', function() { bgText.value = this.value; });
            }
            if (txtPicker) {
                txtPicker.addEventListener('input', function() { txtText.value = this.value; });
            }
        </script>
    @endpush
@endsection
