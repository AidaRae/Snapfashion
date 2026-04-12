@extends('layouts.admin')

@section('admin')
    <style>
        .form-input { width: 100%; background: transparent; border: 1.5px solid #e5e7eb; border-radius: 12px; padding: 10px 14px; font-size: 13.5px; color: #1f2937; outline: none; font-family: 'DM Sans', sans-serif; transition: border-color 0.15s, box-shadow 0.15s; }
        .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12); }
        .form-input::placeholder { color: #9ca3af; }
        .dark .form-input { border-color: #374151; color: #f3f4f6; background: rgba(255, 255, 255, 0.03); }
        .dark .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
        .dark .form-input::placeholder { color: #6b7280; }
        .form-label { display: block; font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280; margin-bottom: 6px; }
        .dark .form-label { color: #9ca3af; }
        .save-btn { display: inline-flex; align-items: center; gap: 7px; background: #3b82f6; color: #fff; font-weight: 600; font-size: 13.5px; border-radius: 12px; padding: 11px 26px; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; box-shadow: 0 2px 14px rgba(59, 130, 246, 0.32); transition: background 0.15s, box-shadow 0.15s, transform 0.1s; }
        .save-btn:hover { background: #3b82f6; box-shadow: 0 4px 20px rgba(59, 130, 246, 0.42); }
        .save-btn:active { transform: scale(0.98); }
        .reset-btn { display: inline-flex; align-items: center; gap: 7px; background: transparent; color: #6b7280; font-weight: 600; font-size: 13.5px; border-radius: 12px; padding: 11px 22px; border: 1.5px solid #e5e7eb; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background 0.15s, color 0.15s, border-color 0.15s; }
        .reset-btn:hover { background: #f9fafb; color: #374151; }
        .dark .reset-btn { border-color: #374151; color: #9ca3af; }
        .dark .reset-btn:hover { background: rgba(255, 255, 255, 0.05); color: #e2e8f0; }
        .s-card { background: #fff; border-radius: 20px; border: 1.5px solid #f0f0f0; box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04); overflow: hidden; }
        .dark .s-card { background: #262626; border-color: #404040; box-shadow: 0 1px 12px rgba(0, 0, 0, 0.2); }
        .section-divider { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .section-divider-line { flex: 1; height: 1px; background: #f0f0f0; }
        .dark .section-divider-line { background: #404040; }
        .section-divider-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af; white-space: nowrap; }
    </style>

    <div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-brand dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Payment Settings</span>
        </div>

        {{-- Page heading --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
            <div>
                <h1 style="font-family:'Syne',sans-serif;font-weight:700;"
                    class="text-xl sm:text-2xl text-gray-800 dark:text-gray-100 tracking-tight leading-tight">
                    Payment Settings
                </h1>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                    Manage payment methods and logic.
                </p>
            </div>
        </div>

        <div class="s-card">
            <form action="{{ route('admin.settings.payment.update') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="px-4 sm:px-6 lg:px-8 py-7">

                    {{-- Cash on Delivery --}}
                    <div class="section-divider">
                        <span class="section-divider-label">Cash on Delivery</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div
                        class="flex items-start justify-between gap-4 bg-gray-50 dark:bg-neutral-700/40 rounded-xl p-4 border border-gray-200 dark:border-neutral-600 mb-8">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Enable Cash on Delivery</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Let customers pay with cash when
                                their order is delivered</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer mt-0.5 flex-shrink-0">
                            <input type="hidden" name="enable_cod" value="0">
                            <input type="checkbox" name="enable_cod" value="1" class="sr-only peer"
                                {{ old('enable_cod', $settings->enable_cod ?? 1) ? 'checked' : '' }}>
                            <div
                                class="w-10 h-6 bg-gray-300 dark:bg-neutral-600 peer-checked:bg-brand rounded-full transition-colors duration-200 after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:rounded-full after:h-[18px] after:w-[18px] after:transition-all peer-checked:after:translate-x-4">
                            </div>
                        </label>
                    </div>

                    {{-- Bank Transfer --}}
                    <div class="section-divider">
                        <span class="section-divider-label">Bank Transfer Settings</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div
                        class="flex items-start justify-between gap-4 bg-gray-50 dark:bg-neutral-700/40 rounded-xl p-4 border border-gray-200 dark:border-neutral-600 mb-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Enable Bank Transfer</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Allow direct money transfers into
                                your account</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer mt-0.5 flex-shrink-0">
                            <input type="hidden" name="enable_bank_transfer" value="0">
                            <input type="checkbox" name="enable_bank_transfer" value="1" class="sr-only peer"
                                {{ old('enable_bank_transfer', $settings->enable_bank_transfer ?? 0) ? 'checked' : '' }}>
                            <div
                                class="w-10 h-6 bg-gray-300 dark:bg-neutral-600 peer-checked:bg-brand rounded-full transition-colors duration-200 after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:rounded-full after:h-[18px] after:w-[18px] after:transition-all peer-checked:after:translate-x-4">
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name"
                                value="{{ old('bank_name', $settings->bank_name ?? '') }}"
                                placeholder="e.g. Guaranty Trust Bank" class="form-input" />
                        </div>
                        <div>
                            <label class="form-label">Account Number</label>
                            <input type="text" name="bank_account_number"
                                value="{{ old('bank_account_number', $settings->bank_account_number ?? '') }}"
                                placeholder="0123456789" class="form-input" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Account Name</label>
                            <input type="text" name="bank_account_name"
                                value="{{ old('bank_account_name', $settings->bank_account_name ?? '') }}"
                                placeholder="Snapfashion LTD" class="form-input" />
                        </div>
                    </div>

                    {{-- Paystack --}}
                    <div class="section-divider">
                        <span class="section-divider-label">Paystack Integrated Payments</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div
                        class="flex items-start justify-between gap-4 bg-gray-50 dark:bg-neutral-700/40 rounded-xl p-4 border border-gray-200 dark:border-neutral-600 mb-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Enable Paystack</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Accept cards, bank transfers, USSD
                                securely via Paystack</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer mt-0.5 flex-shrink-0">
                            <input type="hidden" name="enable_paystack" value="0">
                            <input type="checkbox" name="enable_paystack" value="1" class="sr-only peer"
                                {{ old('enable_paystack', $settings->enable_paystack ?? 1) ? 'checked' : '' }}>
                            <div
                                class="w-10 h-6 bg-gray-300 dark:bg-neutral-600 peer-checked:bg-brand rounded-full transition-colors duration-200 after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:rounded-full after:h-[18px] after:w-[18px] after:transition-all peer-checked:after:translate-x-4">
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label class="form-label">Paystack Public Key</label>
                            <input type="text" name="paystack_public_key"
                                value="{{ old('paystack_public_key', $settings->paystack_public_key ?? '') }}"
                                placeholder="pk_test_xxxxxxxxxx" class="form-input font-mono text-xs" />
                        </div>
                        <div>
                            <label class="form-label">Paystack Secret Key</label>
                            <input type="password" name="paystack_secret_key"
                                value="{{ old('paystack_secret_key', $settings->paystack_secret_key ?? '') }}"
                                placeholder="sk_test_xxxxxxxxxx" class="form-input font-mono text-xs" />
                        </div>
                    </div>

                    {{-- Flutterwave --}}
                    <div class="section-divider">
                        <span class="section-divider-label">Flutterwave Integrated Payments</span>
                        <div class="section-divider-line"></div>
                    </div>

                    <div
                        class="flex items-start justify-between gap-4 bg-gray-50 dark:bg-neutral-700/40 rounded-xl p-4 border border-gray-200 dark:border-neutral-600 mb-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Enable Flutterwave</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Accept fast and secure global/local payments via Flutterwave</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer mt-0.5 flex-shrink-0">
                            <input type="hidden" name="enable_flutterwave" value="0">
                            <input type="checkbox" name="enable_flutterwave" value="1" class="sr-only peer"
                                {{ old('enable_flutterwave', $settings->enable_flutterwave ?? 0) ? 'checked' : '' }}>
                            <div
                                class="w-10 h-6 bg-gray-300 dark:bg-neutral-600 peer-checked:bg-brand rounded-full transition-colors duration-200 after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:rounded-full after:h-[18px] after:w-[18px] after:transition-all peer-checked:after:translate-x-4">
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                        <div>
                            <label class="form-label">Flutterwave Public Key</label>
                            <input type="text" name="flutterwave_public_key"
                                value="{{ old('flutterwave_public_key', $settings->flutterwave_public_key ?? '') }}"
                                placeholder="FLWPUBK_TEST-xxxxxxxxxx" class="form-input font-mono text-xs" />
                        </div>
                        <div>
                            <label class="form-label">Flutterwave Secret Key</label>
                            <input type="password" name="flutterwave_secret_key"
                                value="{{ old('flutterwave_secret_key', $settings->flutterwave_secret_key ?? '') }}"
                                placeholder="FLWSECK_TEST-xxxxxxxxxx" class="form-input font-mono text-xs" />
                        </div>
                    </div>

                </div>

                <div
                    class="px-4 sm:px-6 lg:px-8 py-5
                        border-t border-gray-100 dark:border-neutral-700/80
                        flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 hidden sm:block">
                        Changes are applied immediately after saving.
                    </p>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="reset" class="reset-btn flex-1 sm:flex-none justify-center">
                            Reset
                        </button>
                        <button type="submit" class="save-btn flex-1 sm:flex-none justify-center">
                            Update Settings
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
