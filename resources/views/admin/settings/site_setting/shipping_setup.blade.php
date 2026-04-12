@extends('layouts.admin')

@section('admin')

<div class="p-4 sm:p-6 max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-1">
            <a href="{{ route('admin.settings') }}" class="hover:text-brand transition-colors">Settings</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-500 dark:text-gray-400">Shipping</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white">Shipping Settings</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Configure delivery zones and rates across Nigeria</p>
            </div>
            {{-- Nigeria flag accent --}}
            <div class="hidden sm:flex items-center gap-2 bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl px-3 py-2 shadow-sm">
                <span class="text-lg">🇳🇬</span>
                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Nigeria</span>
            </div>
        </div>
    </div>

    {{-- Session Alerts --}}
    @if(session('success'))
    <div class="mb-4 flex items-center gap-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl px-4 py-3 text-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl px-4 py-3 text-sm">
        <p class="font-semibold mb-1">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.settings.shipping.update') }}" method="POST" id="shippingForm">
        @csrf
        @method('PUT')

        <div class="space-y-5">

            {{-- ── GENERAL SHIPPING ─────────────────────────── --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-gray-200 dark:border-neutral-700 overflow-hidden shadow-sm">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 dark:border-neutral-700">
                    <div class="w-8 h-8 rounded-lg bg-brand-pale dark:bg-brand/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1.414 9.172A2 2 0 008.4 19h7.2a2 2 0 001.986-1.828L18.5 8M10 12h4"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">General Shipping</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Base configuration for all deliveries</p>
                    </div>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Free Shipping Threshold --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">
                            Free Shipping Threshold (₦)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400 dark:text-gray-500">₦</span>
                            <input type="number" name="free_shipping_threshold" min="0" step="100"
                                value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold'] ?? 15000) }}"
                                class="w-full pl-8 pr-4 py-2.5 rounded-xl bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Orders above this amount qualify for free shipping. Set 0 to disable.</p>
                    </div>

                    {{-- Default Estimated Delivery --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">
                            Default Delivery Estimate
                        </label>
                        <input type="text" name="default_delivery_estimate"
                            value="{{ old('default_delivery_estimate', $settings['default_delivery_estimate'] ?? '3 - 5 business days') }}"
                            placeholder="e.g. 3 - 5 business days"
                            class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Shown to customers at checkout if no zone match.</p>
                    </div>

                    {{-- Shipping Origin --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">
                            Shipping Origin State
                        </label>
                        <select name="origin_state"
                            class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                            @php
                                $nigeriaStates = [
                                    'Abia','Adamawa','Akwa Ibom','Anambra','Bauchi','Bayelsa','Benue','Borno',
                                    'Cross River','Delta','Ebonyi','Edo','Ekiti','Enugu','FCT - Abuja','Gombe',
                                    'Imo','Jigawa','Kaduna','Kano','Katsina','Kebbi','Kogi','Kwara','Lagos',
                                    'Nasarawa','Niger','Ogun','Ondo','Osun','Oyo','Plateau','Rivers','Sokoto',
                                    'Taraba','Yobe','Zamfara'
                                ];
                                $currentOrigin = old('origin_state', $settings['origin_state'] ?? 'Lagos');
                            @endphp
                            @foreach($nigeriaStates as $state)
                                <option value="{{ $state }}" class="bg-white text-gray-900 dark:bg-neutral-800 dark:text-gray-100" @selected($currentOrigin === $state)>{{ $state }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Your warehouse / dispatch location.</p>
                    </div>

                    {{-- Cash on Delivery toggle --}}
                    <div class="flex items-start justify-between gap-4 sm:col-span-1 bg-gray-50 dark:bg-neutral-700/40 rounded-xl p-4 border border-gray-200 dark:border-neutral-600">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Cash on Delivery (COD)</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Allow customers to pay upon delivery</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer mt-0.5 flex-shrink-0">
                            <input type="hidden" name="cod_enabled" value="0">
                            <input type="checkbox" name="cod_enabled" value="1" class="sr-only peer"
                                {{ old('cod_enabled', $settings['cod_enabled'] ?? true) ? 'checked' : '' }}>
                            <div class="w-10 h-6 bg-gray-300 dark:bg-neutral-600 peer-checked:bg-brand rounded-full transition-colors duration-200 after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:rounded-full after:h-[18px] after:w-[18px] after:transition-all peer-checked:after:translate-x-4"></div>
                        </label>
                    </div>

                </div>
            </div>

            {{-- ── SHIPPING ZONES ────────────────────────────── --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-gray-200 dark:border-neutral-700 overflow-hidden shadow-sm">
                <div class="flex items-center justify-between gap-3 px-5 py-4 border-b border-gray-100 dark:border-neutral-700">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-brand-pale dark:bg-brand/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Shipping Zones & Rates</h2>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Define rates per Nigerian region</p>
                        </div>
                    </div>
                    <button type="button" onclick="addZoneRow()"
                        class="add-btn text-xs px-3 py-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Add Zone
                    </button>
                </div>

                {{-- Zone table header --}}
                <div class="hidden sm:grid grid-cols-12 gap-3 px-5 py-2.5 bg-gray-50 dark:bg-neutral-700/40 border-b border-gray-100 dark:border-neutral-700 text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">
                    <div class="col-span-3">Zone Name</div>
                    <div class="col-span-4">States Covered</div>
                    <div class="col-span-2">Rate (₦)</div>
                    <div class="col-span-2">Delivery Days</div>
                    <div class="col-span-1 text-right">Del</div>
                </div>

                <div id="zonesContainer" class="divide-y divide-gray-100 dark:divide-neutral-700">

                    @php
                        $defaultZones = [
                            ['name' => 'Lagos Same-Day', 'states' => 'Lagos', 'rate' => 1500, 'days' => '1 - 2', 'enabled' => true],
                            ['name' => 'South-West', 'states' => 'Ogun, Oyo, Osun, Ondo, Ekiti', 'rate' => 2500, 'days' => '2 - 3', 'enabled' => true],
                            ['name' => 'South-South', 'states' => 'Rivers, Delta, Edo, Bayelsa, Cross River, Akwa Ibom', 'rate' => 3000, 'days' => '3 - 5', 'enabled' => true],
                            ['name' => 'South-East', 'states' => 'Anambra, Imo, Enugu, Abia, Ebonyi', 'rate' => 3000, 'days' => '3 - 5', 'enabled' => true],
                            ['name' => 'North-Central', 'states' => 'FCT - Abuja, Kogi, Benue, Nasarawa, Niger, Plateau, Kwara', 'rate' => 3500, 'days' => '4 - 6', 'enabled' => true],
                            ['name' => 'North-West', 'states' => 'Kano, Kaduna, Katsina, Jigawa, Kebbi, Sokoto, Zamfara', 'rate' => 4000, 'days' => '5 - 7', 'enabled' => true],
                            ['name' => 'North-East', 'states' => 'Borno, Yobe, Adamawa, Gombe, Bauchi, Taraba', 'rate' => 4500, 'days' => '5 - 7', 'enabled' => false],
                        ];
                        $zones = old('zones', $settings['zones'] ?? $defaultZones);
                    @endphp

                    @foreach($zones as $i => $zone)
                    <div class="zone-row grid grid-cols-12 gap-3 px-5 py-3.5 items-start" data-index="{{ $i }}">
                        {{-- Zone Name --}}
                        <div class="col-span-12 sm:col-span-3">
                            <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1 block">Zone Name</label>
                            <input type="text" name="zones[{{ $i }}][name]"
                                value="{{ $zone['name'] }}"
                                placeholder="Zone name"
                                class="w-full px-3 py-2 rounded-lg bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        </div>
                        {{-- States --}}
                        <div class="col-span-12 sm:col-span-4">
                            <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1 block">States</label>
                            <input type="text" name="zones[{{ $i }}][states]"
                                value="{{ $zone['states'] }}"
                                placeholder="Lagos, Ogun, ..."
                                class="w-full px-3 py-2 rounded-lg bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        </div>
                        {{-- Rate --}}
                        <div class="col-span-5 sm:col-span-2">
                            <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1 block">Rate (₦)</label>
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">₦</span>
                                <input type="number" name="zones[{{ $i }}][rate]" min="0" step="50"
                                    value="{{ $zone['rate'] }}"
                                    class="w-full pl-6 pr-2 py-2 rounded-lg bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                            </div>
                        </div>
                        {{-- Days --}}
                        <div class="col-span-5 sm:col-span-2">
                            <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1 block">Days</label>
                            <input type="text" name="zones[{{ $i }}][days]"
                                value="{{ $zone['days'] }}"
                                placeholder="3 - 5"
                                class="w-full px-3 py-2 rounded-lg bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        </div>
                        {{-- Delete --}}
                        <div class="col-span-2 sm:col-span-1 flex items-center justify-end pt-1">
                            <button type="button" onclick="removeZoneRow(this)"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach

                </div>

                {{-- Empty state --}}
                <div id="zonesEmpty" class="hidden px-5 py-10 text-center">
                    <div class="w-12 h-12 bg-gray-100 dark:bg-neutral-700 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No shipping zones yet. Click <strong>Add Zone</strong> to get started.</p>
                </div>

                <div class="px-5 py-3 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/50 dark:bg-neutral-700/20">
                    <p class="text-xs text-gray-400 dark:text-gray-500">
                        <span class="font-semibold text-gray-500 dark:text-gray-400">Tip:</span>
                        Separate multiple states with commas. The most specific zone match wins at checkout.
                    </p>
                </div>
            </div>

            {{-- ── COURIER / LOGISTICS PARTNERS ─────────────── --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-gray-200 dark:border-neutral-700 overflow-hidden shadow-sm">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 dark:border-neutral-700">
                    <div class="w-8 h-8 rounded-lg bg-brand-pale dark:bg-brand/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Logistics Partners</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Enable the couriers you work with in Nigeria</p>
                    </div>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-3">

                    @php
                        $couriers = [
                            ['key' => 'gigl',       'name' => 'GIG Logistics',    'desc' => 'Pan-Nigeria coverage, popular for e-commerce'],
                            ['key' => 'dhl_ng',     'name' => 'DHL Nigeria',       'desc' => 'International & domestic express delivery'],
                            ['key' => 'redstar',    'name' => 'Redstar Express',   'desc' => 'Nationwide courier & cargo services'],
                            ['key' => 'fedex_ng',   'name' => 'FedEx Nigeria',     'desc' => 'International shipping & local deliveries'],
                            ['key' => 'kwik',       'name' => 'Kwik Delivery',     'desc' => 'Same-day delivery, Lagos & Abuja'],
                            ['key' => 'sendbox',    'name' => 'Sendbox',           'desc' => 'Logistics API, nationwide fulfilment'],
                        ];
                        $settingsCouriers = $settings['couriers'] ?? [];
                    @endphp

                    @foreach($couriers as $courier)
                    <label class="flex items-start gap-3 p-3.5 rounded-xl border cursor-pointer transition-all
                        {{ old('couriers.'.$courier['key'], $settingsCouriers[$courier['key']] ?? false) ? 'border-brand bg-brand-pale/50 dark:bg-brand/10 dark:border-brand/40' : 'border-gray-200 dark:border-neutral-700 hover:border-brand/40 hover:bg-gray-50 dark:hover:bg-neutral-700/40' }}"
                        id="courier-label-{{ $courier['key'] }}">
                        <input type="hidden" name="couriers[{{ $courier['key'] }}]" value="0">
                        <input type="checkbox" name="couriers[{{ $courier['key'] }}]" value="1"
                            {{ old('couriers.'.$courier['key'], $settingsCouriers[$courier['key']] ?? false) ? 'checked' : '' }}
                            class="mt-0.5 flex-shrink-0 courier-checkbox"
                            data-label="courier-label-{{ $courier['key'] }}">
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $courier['name'] }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $courier['desc'] }}</p>
                        </div>
                    </label>
                    @endforeach

                </div>
            </div>

            {{-- ── SPECIAL CONDITIONS ────────────────────────── --}}
            <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-gray-200 dark:border-neutral-700 overflow-hidden shadow-sm">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 dark:border-neutral-700">
                    <div class="w-8 h-8 rounded-lg bg-brand-pale dark:bg-brand/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Special Conditions</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Remote areas, bulky items, extra charges</p>
                    </div>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Remote area surcharge --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">
                            Remote Area Surcharge (₦)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">₦</span>
                            <input type="number" name="remote_area_surcharge" min="0" step="50"
                                value="{{ old('remote_area_surcharge', $settings['remote_area_surcharge'] ?? 1000) }}"
                                class="w-full pl-8 pr-4 py-2.5 rounded-xl bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Added to delivery fee for hard-to-reach locations.</p>
                    </div>

                    {{-- Bulky item surcharge --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">
                            Bulky Item Surcharge (₦)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">₦</span>
                            <input type="number" name="bulky_surcharge" min="0" step="50"
                                value="{{ old('bulky_surcharge', $settings['bulky_surcharge'] ?? 2000) }}"
                                class="w-full pl-8 pr-4 py-2.5 rounded-xl bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Extra fee for oversized or heavy products.</p>
                    </div>

                    {{-- Bulky weight threshold --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">
                            Bulky Weight Threshold (kg)
                        </label>
                        <input type="number" name="bulky_weight_kg" min="0" step="0.5"
                            value="{{ old('bulky_weight_kg', $settings['bulky_weight_kg'] ?? 10) }}"
                            class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Orders above this weight are flagged as bulky.</p>
                    </div>

                    {{-- Public holiday notice --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">
                            Holiday / Delay Notice
                        </label>
                        <input type="text" name="holiday_notice"
                            value="{{ old('holiday_notice', $settings['holiday_notice'] ?? '') }}"
                            placeholder="e.g. Deliveries may be delayed due to public holidays"
                            class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Displayed at checkout when active. Leave blank to hide.</p>
                    </div>

                </div>
            </div>

            {{-- ── SAVE BAR ──────────────────────────────────── --}}
            <div class="flex items-center justify-between gap-3 bg-white dark:bg-neutral-800 rounded-2xl border border-gray-200 dark:border-neutral-700 px-5 py-4 shadow-sm sticky bottom-4 lg:bottom-6 z-10">
                <p class="text-xs text-gray-400 dark:text-gray-500 hidden sm:block">Changes apply immediately to your storefront.</p>
                <div class="flex items-center gap-3 ml-auto">
                    <a href="{{ route('admin.settings') }}"
                        class="px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="add-btn px-5 py-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Save Shipping Settings
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    let zoneIndex = {{ count($zones ?? $defaultZones) }};

    const nigeriaStates = [
        'Abia','Adamawa','Akwa Ibom','Anambra','Bauchi','Bayelsa','Benue','Borno',
        'Cross River','Delta','Ebonyi','Edo','Ekiti','Enugu','FCT - Abuja','Gombe',
        'Imo','Jigawa','Kaduna','Kano','Katsina','Kebbi','Kogi','Kwara','Lagos',
        'Nasarawa','Niger','Ogun','Ondo','Osun','Oyo','Plateau','Rivers','Sokoto',
        'Taraba','Yobe','Zamfara'
    ];

    function addZoneRow() {
        const container = document.getElementById('zonesContainer');
        const empty = document.getElementById('zonesEmpty');
        const i = zoneIndex++;

        const row = document.createElement('div');
        row.className = 'zone-row grid grid-cols-12 gap-3 px-5 py-3.5 items-start';
        row.dataset.index = i;
        row.innerHTML = `
            <div class="col-span-12 sm:col-span-3">
                <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1 block">Zone Name</label>
                <input type="text" name="zones[${i}][name]" placeholder="Zone name"
                    class="w-full px-3 py-2 rounded-lg bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
            </div>
            <div class="col-span-12 sm:col-span-4">
                <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1 block">States</label>
                <input type="text" name="zones[${i}][states]" placeholder="Lagos, Ogun, ..."
                    class="w-full px-3 py-2 rounded-lg bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
            </div>
            <div class="col-span-5 sm:col-span-2">
                <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1 block">Rate (₦)</label>
                <div class="relative">
                    <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">₦</span>
                    <input type="number" name="zones[${i}][rate]" min="0" step="50" placeholder="0"
                        class="w-full pl-6 pr-2 py-2 rounded-lg bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
                </div>
            </div>
            <div class="col-span-5 sm:col-span-2">
                <label class="sm:hidden text-[10px] font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-1 block">Days</label>
                <input type="text" name="zones[${i}][days]" placeholder="3 - 5"
                    class="w-full px-3 py-2 rounded-lg bg-gray-50 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-600 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-brand/40 focus:border-brand">
            </div>
            <div class="col-span-2 sm:col-span-1 flex items-center justify-end pt-1">
                <button type="button" onclick="removeZoneRow(this)"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        `;

        // animate in
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

    function removeZoneRow(btn) {
        const row = btn.closest('.zone-row');
        row.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(8px)';
        setTimeout(() => {
            row.remove();
            const container = document.getElementById('zonesContainer');
            if (container.querySelectorAll('.zone-row').length === 0) {
                document.getElementById('zonesEmpty').classList.remove('hidden');
            }
        }, 150);
    }

    // Courier checkbox highlight toggle
    document.querySelectorAll('.courier-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            const label = document.getElementById(this.dataset.label);
            if (this.checked) {
                label.classList.remove('border-gray-200', 'dark:border-neutral-700');
                label.classList.add('border-brand', 'bg-brand-pale/50', 'dark:bg-brand/10', 'dark:border-brand/40');
            } else {
                label.classList.add('border-gray-200', 'dark:border-neutral-700');
                label.classList.remove('border-brand', 'bg-brand-pale/50', 'dark:bg-brand/10', 'dark:border-brand/40');
            }
        });
    });

    // Confirm before leaving with unsaved changes
    let formChanged = false;
    document.getElementById('shippingForm').addEventListener('change', () => { formChanged = true; });
    document.getElementById('shippingForm').addEventListener('submit', () => { formChanged = false; });
    window.addEventListener('beforeunload', e => {
        if (formChanged) { e.preventDefault(); e.returnValue = ''; }
    });
</script>
@endpush