@extends('layouts.admin')
@section('title', 'Notifications')

@section('admin')
<main class="flex-1 w-full flex flex-col pt-20 lg:pt-0">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 style="font-family:'Syne',sans-serif;font-weight:700;" class="text-3xl tracking-tight text-gray-900 dark:text-white mb-2">
                    Notifications
                    @if(auth('admin')->user()->unreadNotifications->count() > 0)
                        <span class="text-brand font-medium tracking-normal text-xl ml-2 bg-brand/10 px-3 py-1 rounded-full">{{ auth('admin')->user()->unreadNotifications->count() }} new</span>
                    @endif
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">View and manage all your system alerts, payments, and customer activities.</p>
            </div>
            
            @if(auth('admin')->user()->unreadNotifications->count() > 0)
                <div class="flex gap-3">
                    <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-neutral-700/50 px-4 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Mark all as read
                        </button>
                    </form>
                </div>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 p-4 rounded-xl text-sm flex items-center justify-between border border-emerald-100 dark:border-emerald-500/20">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Notifications List -->
        <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-gray-100 dark:border-neutral-700 overflow-hidden shadow-sm">
            <div class="divide-y divide-gray-50 dark:divide-neutral-700/50">
                @forelse($notifications as $notification)
                    <div class="p-5 sm:p-6 hover:bg-gray-50/50 dark:hover:bg-neutral-700/30 transition-colors flex gap-4 sm:gap-6 relative {{ is_null($notification->read_at) ? 'bg-brand/5 dark:bg-brand/10' : '' }}">
                        
                        @if(is_null($notification->read_at))
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand rounded-r"></div>
                        @endif

                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl flex items-center justify-center flex-shrink-0
                            {{ $notification->data['type'] == 'new_payment' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : '' }}
                            {{ $notification->data['type'] == 'payment_failure' ? 'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400' : '' }}
                            {{ $notification->data['type'] == 'new_order' ? 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400' : '' }}
                            {{ $notification->data['type'] == 'new_customer' ? 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400' : '' }}
                        ">
                            @if($notification->data['type'] == 'new_payment')
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @elseif($notification->data['type'] == 'payment_failure')
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @elseif($notification->data['type'] == 'new_order')
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            @else
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="sm:flex sm:items-baseline sm:justify-between">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1 sm:mb-0">
                                    {{ $notification->data['title'] }}
                                </h3>
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    {{ $notification->created_at->format('M d, Y • g:i A') }}
                                </p>
                            </div>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 mb-3">
                                {{ $notification->data['message'] }}
                            </p>
                            
                            <div class="flex items-center gap-4">
                                @if($notification->data['url'] ?? false)
                                    <a href="{{ $notification->data['url'] }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-lg transition-colors border border-transparent">
                                        View Details
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @endif
                                
                                @if(is_null($notification->read_at))
                                    <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 text-brand hover:text-brand-light text-xs font-semibold transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Mark as read
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 dark:bg-neutral-800 mb-6">
                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Notifications</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">You're all caught up! When you receive new orders, payments, or registrations, they will appear here.</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-neutral-700 bg-gray-50/30 dark:bg-neutral-800/50">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>

    </div>
</main>
@endsection
