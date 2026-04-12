@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('admin')
<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
    
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 font-medium tracking-wide uppercase mb-2">
                <span>Dashboard</span>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-brand">Settings</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 dark:text-white">Profile Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your account identity and security preferences.</p>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 px-5 py-4 rounded-2xl border border-emerald-100 dark:border-emerald-500/20 text-sm font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 px-5 py-4 rounded-2xl border border-red-100 dark:border-red-500/20 text-sm font-semibold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 012 0v4a1 1 0 01-2 0V9zm1-5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 px-5 py-4 rounded-2xl border border-red-100 dark:border-red-500/20 text-sm shadow-sm">
            <p class="font-bold mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 012 0v4a1 1 0 01-2 0V9zm1-5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                Please fix the following issues:
            </p>
            <ul class="list-disc list-inside space-y-1 ml-7 font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- ── LEFT SIDEBAR ── --}}
        <div class="lg:w-1/3 xl:w-1/4 flex-shrink-0 space-y-6">
            
            {{-- User Profile Snippet --}}
            <div class="bg-white dark:bg-[#262626] rounded-3xl border border-gray-100 dark:border-[#404040] p-6 shadow-sm text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-24 bg-brand/5 dark:bg-[#404040]/30 hidden sm:block"></div>
                <div class="relative inline-block group mb-4 mt-2 sm:mt-6">
                    <div class="w-24 h-24 rounded-full border-4 border-white dark:border-[#262626] bg-brand-pale dark:bg-brand/20 overflow-hidden flex items-center justify-center shadow-lg mx-auto" id="avatarPreview">
                        @if (!empty(auth('admin')->user()->avatar))
                            <img src="{{ asset('storage/' . auth('admin')->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover" id="avatarImg">
                        @else
                            <span class="text-3xl font-display font-bold text-brand select-none" id="avatarInitials">
                                {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                            </span>
                            <img src="" alt="" class="w-full h-full object-cover hidden" id="avatarImg">
                        @endif
                    </div>
                    <label for="avatarUpload" class="absolute inset-0 rounded-full bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </label>
                </div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ auth('admin')->user()->name ?? 'Administrator' }}</h2>
                <div class="inline-flex items-center gap-1.5 mt-1 px-2.5 py-1 rounded-full bg-brand/10 dark:bg-brand/20 text-[10px] font-bold text-brand uppercase tracking-widest border border-brand/10">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand animate-pulse"></span>
                    Master
                </div>
                <div class="mt-5 text-sm font-medium text-gray-500 dark:text-gray-400 break-all bg-gray-50 dark:bg-[#1a1a1a] rounded-xl p-3 border border-gray-100 dark:border-[#404040]">
                    {{ auth('admin')->user()->email ?? 'admin@example.com' }}
                </div>
            </div>

            {{-- Navigation Tabs --}}
            <nav class="bg-white dark:bg-[#262626] rounded-3xl border border-gray-100 dark:border-[#404040] p-3 shadow-sm flex flex-col gap-1.5">
                <button type="button" onclick="switchTab('info')" id="tab-info" class="tab-btn w-full text-left px-5 py-3.5 rounded-2xl text-sm font-bold transition-all bg-gray-50 dark:bg-[#404040]/50 text-brand dark:text-white flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Personal Details
                </button>
                <button type="button" onclick="switchTab('password')" id="tab-password" class="tab-btn w-full text-left px-5 py-3.5 rounded-2xl text-sm font-bold transition-all text-gray-500 dark:text-gray-400 hover:bg-gray-50 hover:text-gray-900 dark:hover:bg-[#404040]/30 dark:hover:text-white flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Security
                </button>
                <div class="my-1 border-t border-gray-100 dark:border-[#404040] mx-4"></div>
                <button type="button" onclick="switchTab('activity')" id="tab-activity" class="tab-btn w-full text-left px-5 py-3.5 rounded-2xl text-sm font-bold transition-all text-gray-500 dark:text-gray-400 hover:bg-gray-50 hover:text-gray-900 dark:hover:bg-[#404040]/30 dark:hover:text-white flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Activity Log
                </button>
            </nav>

            {{-- Mini Stats --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-brand to-brand-light rounded-3xl p-5 shadow-lg shadow-brand/20 text-white flex flex-col justify-between">
                    <svg class="w-6 h-6 text-white/70 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <div>
                        <p class="text-[10px] text-white/80 uppercase tracking-widest font-bold mb-0.5">Orders</p>
                        <p class="text-2xl font-display font-bold">{{ $stats['total_orders'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-gray-900 dark:bg-black rounded-3xl p-5 shadow-lg text-white flex flex-col justify-between">
                    <svg class="w-6 h-6 text-white/50 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-0.5">Products</p>
                        <p class="text-2xl font-display font-bold">{{ $stats['total_products'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── RIGHT CONTENT AREA ── --}}
        <div class="lg:flex-1">
            
            {{-- TAB: INFO --}}
            <div id="panel-info" class="animate-fade-in block">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="infoForm" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    {{-- Hidden Avatar Input --}}
                    <input type="file" name="avatar" id="avatarFormFile" accept="image/*" class="hidden">

                    <div class="bg-white dark:bg-[#262626] rounded-3xl border border-gray-100 dark:border-[#404040] shadow-sm overflow-hidden">
                        <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-100 dark:border-[#404040]">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Personal Details</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1.5">Update your basic profile information and how others see you.</p>
                        </div>
                        <div class="p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-7">
                            
                            {{-- Full Name --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', auth('admin')->user()->name) }}" placeholder="e.g. John Doe" class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-[#404040] text-sm text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-brand/50 focus:border-brand transition-shadow outline-none">
                            </div>

                            {{-- Username --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Username</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-bold">@</span>
                                    <input type="text" name="username" value="{{ old('username', auth('admin')->user()->username ?? '') }}" placeholder="admin_user" class="w-full pl-9 pr-4 py-3 rounded-2xl bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-[#404040] text-sm text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-brand/50 focus:border-brand transition-shadow outline-none">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', auth('admin')->user()->email) }}" class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-[#404040] text-sm text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-brand/50 focus:border-brand transition-shadow outline-none">
                            </div>

                            {{-- Phone --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Phone Number</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 select-none">🇳🇬</span>
                                    <input type="tel" name="phone" value="{{ old('phone', auth('admin')->user()->phone ?? '') }}" placeholder="+234 800 000 0000" class="w-full pl-12 pr-4 py-3 rounded-2xl bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-[#404040] text-sm text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-brand/50 focus:border-brand transition-shadow outline-none">
                                </div>
                            </div>

                            {{-- Bio --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Bio</label>
                                <textarea name="bio" rows="4" placeholder="Brief description for your profile..." class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-[#404040] text-sm text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-brand/50 focus:border-brand transition-shadow resize-none outline-none">{{ old('bio', auth('admin')->user()->bio ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Preferences Section --}}
                    <div class="bg-white dark:bg-[#262626] rounded-3xl border border-gray-100 dark:border-[#404040] shadow-sm overflow-hidden mb-8">
                        <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-100 dark:border-[#404040]">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">System Preferences</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1.5">Control your notifications and dashboard layout.</p>
                        </div>
                        <div class="p-0">
                            @php
                                $prefs = [
                                    ['key' => 'notify_new_order', 'label' => 'New Order Notifications', 'desc' => 'Receive alerts when a customer places an order.'],
                                    ['key' => 'notify_low_stock', 'label' => 'Low Stock Alerts', 'desc' => 'Get notified when product inventory runs low.'],
                                    ['key' => 'notify_new_customer', 'label' => 'New Customer Registrations', 'desc' => 'Alerts for new user account creations.'],
                                    ['key' => 'show_revenue_widget', 'label' => 'Display Revenue Widget', 'desc' => 'Show your total revenue prominently on the dashboard.'],
                                ];
                            @endphp
                            @foreach ($prefs as $pref)
                                <div class="flex items-center justify-between p-6 sm:px-8 sm:py-5 {{ !$loop->last ? 'border-b border-gray-100 dark:border-[#404040]' : '' }} hover:bg-gray-50/50 dark:hover:bg-[#1a1a1a]/50 transition-colors">
                                    <div class="pr-6">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ $pref['label'] }}</p>
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 leading-relaxed">{{ $pref['desc'] }}</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                        <input type="hidden" name="prefs[{{ $pref['key'] }}]" value="0">
                                        <input type="checkbox" name="prefs[{{ $pref['key'] }}]" value="1" {{ old('prefs.' . $pref['key'], auth('admin')->user()->preferences[$pref['key']] ?? true) ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-12 h-6 sm:w-14 sm:h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand/20 rounded-full peer dark:bg-[#404040] peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-[20px] after:w-[20px] sm:after:h-[24px] sm:after:w-[24px] after:transition-all dark:border-gray-600 peer-checked:bg-brand"></div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sticky Action Bar --}}
                    <div class="sticky bottom-6 z-20 bg-white/80 dark:bg-[#262626]/80 backdrop-blur-xl rounded-3xl border border-gray-100/50 dark:border-[#404040]/50 shadow-2xl p-4 sm:p-5 flex items-center justify-between">
                        <p class="text-xs font-bold text-gray-500 hidden sm:block ml-3">Unsaved changes will be lost.</p>
                        <div class="flex gap-3 ml-auto w-full sm:w-auto">
                            <button type="reset" class="px-6 py-3 rounded-2xl text-sm font-bold text-gray-700 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-[#404040] dark:hover:bg-neutral-600 transition-colors w-full sm:w-auto text-center">Discard</button>
                            <button type="submit" class="px-8 py-3 rounded-2xl text-sm font-bold text-white bg-brand hover:bg-brand-light transition-all shadow-lg shadow-brand/25 active:scale-95 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Save Changes
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            {{-- TAB: PASSWORD --}}
            <div id="panel-password" class="hidden animate-fade-in space-y-6">
                <form action="{{ route('admin.profile.password.update') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')
                    <div class="bg-white dark:bg-[#262626] rounded-3xl border border-gray-100 dark:border-[#404040] shadow-sm overflow-hidden mb-6">
                        <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-100 dark:border-[#404040]">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Security Settings</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1.5">Ensure your account is using a long, random password.</p>
                        </div>
                        <div class="p-6 sm:p-8 space-y-6 max-w-xl">
                            
                            {{-- Current Password --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Current Password</label>
                                <div class="relative">
                                    <input type="password" name="current_password" id="currentPwd" placeholder="••••••••" class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-[#404040] text-sm text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-brand/50 focus:border-brand transition-all outline-none">
                                    <button type="button" onclick="togglePwd('currentPwd', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>
                            </div>

                            <hr class="border-gray-100 dark:border-[#404040]">

                            {{-- New Password --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">New Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="newPwd" oninput="checkStrength(this.value)" placeholder="Min. 8 characters" class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-[#404040] text-sm text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-brand/50 focus:border-brand transition-all outline-none">
                                    <button type="button" onclick="togglePwd('newPwd', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>
                                {{-- Password Strength Indicator --}}
                                <div class="mt-3 flex gap-1.5 h-1.5" id="strengthWrap" style="display:none;">
                                    <div class="flex-1 bg-gray-200 dark:bg-neutral-700 rounded-full overflow-hidden"><div id="s1" class="h-full w-0 transition-all duration-300"></div></div>
                                    <div class="flex-1 bg-gray-200 dark:bg-neutral-700 rounded-full overflow-hidden"><div id="s2" class="h-full w-0 transition-all duration-300"></div></div>
                                    <div class="flex-1 bg-gray-200 dark:bg-neutral-700 rounded-full overflow-hidden"><div id="s3" class="h-full w-0 transition-all duration-300"></div></div>
                                    <div class="flex-1 bg-gray-200 dark:bg-neutral-700 rounded-full overflow-hidden"><div id="s4" class="h-full w-0 transition-all duration-300"></div></div>
                                </div>
                                <p id="strengthLabel" class="text-xs font-bold mt-2 hidden"></p>
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="confirmPwd" oninput="checkMatch()" placeholder="Repeat new password" class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-[#1a1a1a] border border-gray-200 dark:border-[#404040] text-sm text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-brand/50 focus:border-brand transition-all outline-none">
                                </div>
                                <p id="matchMsg" class="text-xs font-bold mt-2 hidden"></p>
                            </div>

                        </div>
                    </div>
                    
                    <div class="flex justify-end sticky bottom-6 z-20">
                        <button type="submit" class="px-8 py-3.5 rounded-2xl text-sm font-bold text-white bg-gray-900 dark:bg-white dark:text-gray-900 hover:bg-black dark:hover:bg-gray-100 transition-all shadow-xl shadow-gray-900/20 active:scale-95 w-full sm:w-auto text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- TAB: ACTIVITY --}}
            <div id="panel-activity" class="hidden animate-fade-in">
                <div class="bg-white dark:bg-[#262626] rounded-3xl border border-gray-100 dark:border-[#404040] shadow-sm overflow-hidden mb-8">
                    <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-100 dark:border-[#404040] flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50/50 dark:bg-[#1a1a1a]/50">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Activity Log</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1.5">Review your recent actions and sessions.</p>
                        </div>
                        <div class="bg-white dark:bg-[#262626] px-4 py-2.5 rounded-xl text-xs font-bold text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-[#404040] shadow-sm">
                            Last Login: {{ auth('admin')->user()->last_login_at ? \Carbon\Carbon::parse(auth('admin')->user()->last_login_at)->format('M d, Y - h:i A') : 'Unknown' }}
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-[#404040]">
                        @forelse($activities ?? [] as $activity)
                            <div class="p-6 sm:px-8 sm:py-5 hover:bg-gray-50/50 dark:hover:bg-[#1a1a1a]/50 transition-colors flex items-start gap-5">
                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 {{ $activity['type'] === 'order' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400' : ($activity['type'] === 'product' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-gray-100 dark:bg-neutral-800 text-gray-600 dark:text-gray-400') }}">
                                    @if ($activity['type'] === 'order')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    @elseif($activity['type'] === 'product')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @endif
                                </div>
                                <div class="flex-1 pt-0.5">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $activity['description'] }}</p>
                                    <p class="text-xs font-medium text-gray-500 mt-1.5 flex items-center gap-1.5 opacity-80">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="py-16 px-6 text-center">
                                <div class="w-16 h-16 bg-gray-50 dark:bg-[#1a1a1a] rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-[#404040]">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-1">No Activity Yet</h4>
                                <p class="text-sm font-medium text-gray-500 max-w-sm mx-auto">Your recent actions like managing orders and updating products will appear here.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Sign Out All Sessions --}}
                <div class="bg-red-50/80 dark:bg-red-500/5 rounded-3xl border border-red-100 dark:border-red-500/20 p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
                    <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-gradient-to-l from-red-100/50 dark:from-red-500/10 to-transparent pointer-events-none"></div>
                    <div class="relative z-10">
                        <h4 class="text-base font-bold text-red-800 dark:text-red-400 mb-1">Manage Active Sessions</h4>
                        <p class="text-sm font-medium text-red-600/80 dark:text-red-300/80 max-w-md leading-relaxed">If you suspect your account has been compromised, you can terminate all other active sessions across your devices.</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="relative z-10 flex-shrink-0 w-full md:w-auto">
                        @csrf
                        <button type="submit" class="px-6 py-3.5 w-full rounded-2xl text-sm font-bold text-red-700 dark:text-white bg-white dark:bg-red-600 border border-red-200 dark:border-red-500 hover:bg-red-50 dark:hover:bg-red-700 transition-colors shadow-sm">
                            Log Out All Devices
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .animate-fade-in { animation: fadeIn 0.4s ease forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Hide scrollbar for tabs */
    nav::-webkit-scrollbar { display: none; }
    nav { -ms-overflow-style: none; scrollbar-width: none; }
</style>

@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        let activeClasses = ['bg-gray-50', 'dark:bg-[#404040]/50', 'text-brand', 'dark:text-white'];
        let inactiveClasses = ['text-gray-500', 'dark:text-gray-400', 'hover:bg-gray-50', 'dark:hover:bg-[#404040]/30'];
        
        ['info', 'password', 'activity'].forEach(t => {
            const panel = document.getElementById('panel-' + t);
            const btn = document.getElementById('tab-' + t);
            
            if (t === tab) {
                panel.classList.replace('hidden', 'block');
                btn.classList.add(...activeClasses);
                btn.classList.remove(...inactiveClasses);
            } else {
                panel.classList.replace('block', 'hidden');
                btn.classList.remove(...activeClasses);
                btn.classList.add(...inactiveClasses);
            }
        });
    }

    // Initialize tabs nicely
    document.addEventListener("DOMContentLoaded", function() {
        switchTab('info');
    });

    function previewAvatar(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('avatarFormFile').files = dt.files;
        
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('avatarImg');
            const initials = document.getElementById('avatarInitials');
            img.src = e.target.result;
            img.classList.remove('hidden');
            if (initials) initials.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    function togglePwd(id, btn) {
        const input = document.getElementById(id);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.querySelector('.eye-icon').style.opacity = isText ? '1' : '0.4';
    }

    function checkStrength(val) {
        const wrap = document.getElementById('strengthWrap');
        const label = document.getElementById('strengthLabel');
        if (!val) { 
            wrap.style.display = 'none'; 
            label.classList.add('hidden'); 
            return; 
        }
        wrap.style.display = 'flex';
        label.classList.remove('hidden');

        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
        const labels = ['Weak Password', 'Fair Password', 'Good Password', 'Strong Password'];
        const txtColors = ['text-red-500', 'text-orange-500', 'text-yellow-500', 'text-green-500'];

        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById('s' + i);
            bar.style.width = i <= score ? '100%' : '0%';
            bar.style.background = i <= score ? colors[score - 1] : '';
        }
        
        label.textContent = labels[score - 1] || '';
        
        // Remove all previous colors
        txtColors.forEach(c => label.classList.remove(c));
        label.classList.add(txtColors[score - 1]);
    }

    function checkMatch() {
        const np = document.getElementById('newPwd').value;
        const cp = document.getElementById('confirmPwd').value;
        const msg = document.getElementById('matchMsg');
        
        if (!cp) { 
            msg.classList.add('hidden'); 
            return; 
        }
        
        msg.classList.remove('hidden', 'text-green-500', 'text-red-500');
        
        if (np === cp) {
            msg.textContent = '✓ Passwords match';
            msg.classList.add('text-green-500');
        } else {
            msg.textContent = '✗ Passwords do not match';
            msg.classList.add('text-red-500');
        }
    }

    // Form Dirty Checks
    let formDirty = false;
    document.getElementById('infoForm').addEventListener('change', () => formDirty = true);
    document.getElementById('infoForm').addEventListener('submit', () => formDirty = false);
    document.getElementById('infoForm').addEventListener('reset', () => setTimeout(() => formDirty = false, 10));
    
    window.addEventListener('beforeunload', e => { 
        if (formDirty) { 
            e.preventDefault(); 
            e.returnValue = ''; 
        } 
    });
</script>
@endpush
