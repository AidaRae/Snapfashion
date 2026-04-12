@extends('layouts.admin')

@push('title', 'Email Settings')

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
        .test-btn { display: inline-flex; align-items: center; gap: 7px; background: #10b981; color: #fff; font-weight: 600; font-size: 13.5px; border-radius: 12px; padding: 11px 22px; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; box-shadow: 0 2px 14px rgba(16,185,129,0.3); transition: background 0.15s, box-shadow 0.15s, transform 0.1s; }
        .test-btn:hover { background: #059669; box-shadow: 0 4px 20px rgba(16,185,129,0.4); }
        .test-btn:active { transform: scale(0.98); }
        .s-card { background: #fff; border-radius: 20px; border: 1.5px solid #f0f0f0; box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04); overflow: hidden; }
        .dark .s-card { background: #262626; border-color: #404040; box-shadow: 0 1px 12px rgba(0, 0, 0, 0.2); }
        .section-divider { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .section-divider-line { flex: 1; height: 1px; background: #f0f0f0; }
        .dark .section-divider-line { background: #404040; }
        .section-divider-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af; white-space: nowrap; }

        /* Toggle switch */
        .toggle-switch { position: relative; display: inline-flex; align-items: center; cursor: pointer; user-select: none; }
        .toggle-switch input { position: absolute; opacity: 0; width: 0; height: 0; }
        .toggle-track-custom { width: 48px; height: 26px; border-radius: 99px; background: #d1d5db; transition: background 0.25s, box-shadow 0.25s; position: relative; flex-shrink: 0; }
        .dark .toggle-track-custom { background: #4b5563; }
        .toggle-switch input:checked + .toggle-track-custom { background: #3b82f6; box-shadow: 0 0 12px rgba(59, 130, 246,0.3); }
        .toggle-thumb-custom { position: absolute; top: 3px; left: 3px; width: 20px; height: 20px; border-radius: 50%; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.15); transition: transform 0.25s cubic-bezier(0.4,0,0.2,1); }
        .toggle-switch input:checked + .toggle-track-custom .toggle-thumb-custom { transform: translateX(22px); }

        /* Placeholder tag */
        .placeholder-tag { display: inline-block; background: #f3f4f6; color: #6b7280; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 6px; font-family: ui-monospace, monospace; cursor: pointer; transition: background 0.15s, color 0.15s; margin: 2px; }
        .placeholder-tag:hover { background: #3b82f6; color: #fff; }
        .dark .placeholder-tag { background: #374151; color: #9ca3af; }
        .dark .placeholder-tag:hover { background: #3b82f6; color: #fff; }
    </style>

    <div class="p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-5">
            <a href="{{ route('admin.dashboard') }}"
                class="hover:text-brand dark:hover:text-blue-400 transition-colors">Dashboard</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="text-gray-600 dark:text-gray-300 font-medium">Email Settings</span>
        </div>

        {{-- Page heading --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
            <div>
                <h1 style="font-family:'Syne',sans-serif;font-weight:700;"
                    class="text-xl sm:text-2xl text-gray-800 dark:text-gray-100 tracking-tight leading-tight">
                    Email Settings
                </h1>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                    Control how order notification emails behave — no code changes needed.
                </p>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 p-4 rounded-xl text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 flex items-center gap-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-4 rounded-xl text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-4 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Main Form --}}
        <div class="s-card">
            <form action="{{ route('admin.settings.email.update') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="px-4 sm:px-6 lg:px-8 py-7 space-y-8">

                    {{-- ─── 1. Master Toggle ─── --}}
                    <div>
                        <div class="section-divider">
                            <span class="section-divider-label">Email Notifications</span>
                            <div class="section-divider-line"></div>
                        </div>

                        <div class="flex items-center justify-between bg-gray-50 dark:bg-neutral-800/60 rounded-xl px-5 py-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Send Order Emails</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">When enabled, customers receive email notifications for order confirmations and status updates.</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="hidden" name="order_emails_enabled" value="0">
                                <input type="checkbox" name="order_emails_enabled" value="1"
                                    {{ old('order_emails_enabled', $settings->order_emails_enabled ?? true) ? 'checked' : '' }}>
                                <div class="toggle-track-custom">
                                    <div class="toggle-thumb-custom"></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- ─── 2. Sender Identity ─── --}}
                    <div>
                        <div class="section-divider">
                            <span class="section-divider-label">Sender Identity</span>
                            <div class="section-divider-line"></div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label">From Name <span class="text-red-400">*</span></label>
                                <input type="text" name="mail_from_name"
                                    value="{{ old('mail_from_name', $settings->mail_from_name ?? config('app.name')) }}"
                                    placeholder="Snapfashion" class="form-input" required />
                                <p class="text-[11px] text-gray-400 mt-1.5">The name shown in the customer's inbox.</p>
                            </div>
                            <div>
                                <label class="form-label">From Email Address <span class="text-red-400">*</span></label>
                                <input type="email" name="mail_from_address"
                                    value="{{ old('mail_from_address', $settings->mail_from_address ?? config('mail.from.address')) }}"
                                    placeholder="orders@yourdomain.com" class="form-input" required />
                                <p class="text-[11px] text-gray-400 mt-1.5">Emails will appear to come from this address.</p>
                            </div>
                            <div>
                                <label class="form-label">Reply-To Address</label>
                                <input type="email" name="reply_to_address"
                                    value="{{ old('reply_to_address', $settings->reply_to_address ?? '') }}"
                                    placeholder="support@yourdomain.com" class="form-input" />
                                <p class="text-[11px] text-gray-400 mt-1.5">When customers hit "Reply", their response goes here. Leave empty to use the from address.</p>
                            </div>
                            <div>
                                <label class="form-label">BCC Address (Admin Copy)</label>
                                <input type="email" name="bcc_address"
                                    value="{{ old('bcc_address', $settings->bcc_address ?? '') }}"
                                    placeholder="admin@yourdomain.com" class="form-input" />
                                <p class="text-[11px] text-gray-400 mt-1.5">Get a blind copy of every order email. Useful for auditing.</p>
                            </div>
                        </div>
                    </div>

                    {{-- ─── 3. Email Content ─── --}}
                    <div>
                        <div class="section-divider">
                            <span class="section-divider-label">Email Content</span>
                            <div class="section-divider-line"></div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="form-label">Order Confirmation Subject</label>
                                <input type="text" name="order_confirmation_subject"
                                    value="{{ old('order_confirmation_subject', $settings->order_confirmation_subject ?? '') }}"
                                    placeholder="Order Confirmation — #{tracking_code}" class="form-input" />
                                <div class="mt-2">
                                    <span class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mr-1">Placeholders:</span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder(this, 'order_confirmation_subject')">{tracking_code}</span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder(this, 'order_confirmation_subject')">{order_id}</span>
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Status Update Subject</label>
                                <input type="text" name="order_status_subject"
                                    value="{{ old('order_status_subject', $settings->order_status_subject ?? '') }}"
                                    placeholder="Order Update — #{tracking_code} is now {status}" class="form-input" />
                                <div class="mt-2">
                                    <span class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mr-1">Placeholders:</span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder(this, 'order_status_subject')">{tracking_code}</span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder(this, 'order_status_subject')">{order_id}</span>
                                    <span class="placeholder-tag" onclick="insertPlaceholder(this, 'order_status_subject')">{status}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Custom Message Block</label>
                            <textarea name="custom_message" rows="4" class="form-input" style="resize: vertical;"
                                placeholder="e.g. Thank you for shopping with us! Enjoy free returns within 7 days.">{{ old('custom_message', $settings->custom_message ?? '') }}</textarea>
                            <p class="text-[11px] text-gray-400 mt-1.5">This message will appear in every order email, right after the greeting. Leave empty to skip.</p>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-50 dark:bg-blue-900/15 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div class="text-sm text-blue-700 dark:text-blue-300">
                                <p class="font-semibold mb-1">Emails are sent automatically on:</p>
                                <ul class="list-disc list-inside text-xs space-y-1 opacity-80">
                                    <li><strong>Order Confirmation</strong> — When customer submits payment (Paystack, Bank Transfer, COD)</li>
                                    <li><strong>Status Update</strong> — When you change the order status (Processing, Shipped, Delivered, Cancelled)</li>
                                </ul>
                                <p class="text-xs opacity-70 mt-2">SMTP transport is configured via your server environment (.env file).</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div class="px-4 sm:px-6 lg:px-8 py-5
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
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Save Settings
                        </button>
                    </div>
                </div>

            </form>
        </div>

        {{-- Send Test Email Card --}}
        <div class="s-card mt-6">
            <form action="{{ route('admin.settings.email.test') }}" method="POST">
                @csrf
                <div class="px-4 sm:px-6 lg:px-8 py-7">
                    <div class="section-divider">
                        <span class="section-divider-label">Send Test Email</span>
                        <div class="section-divider-line"></div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Verify your email configuration is working by sending a test email. This uses your current .env SMTP settings.</p>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-4">
                        <div class="flex-1">
                            <label class="form-label">Recipient Email</label>
                            <input type="email" name="test_email"
                                value="{{ old('test_email') }}"
                                placeholder="your-email@example.com" class="form-input" required />
                        </div>
                        <button type="submit" class="test-btn flex-shrink-0 justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Send Test Email
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        function insertPlaceholder(tag, inputName) {
            const input = document.querySelector(`input[name="${inputName}"]`);
            if (!input) return;
            const text = tag.textContent;
            const start = input.selectionStart;
            const end = input.selectionEnd;
            const val = input.value;
            input.value = val.substring(0, start) + text + val.substring(end);
            input.focus();
            input.setSelectionRange(start + text.length, start + text.length);
        }
    </script>
@endsection
