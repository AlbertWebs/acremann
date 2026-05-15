@php
    $user = filament()->auth()->user();
@endphp

@if ($user)
    <div class="acremann-sidebar-footer">
        <div class="acremann-sidebar-user">
            <x-filament-panels::avatar.user :user="$user" class="acremann-sidebar-avatar" />
            <div
                class="acremann-sidebar-user-text"
                @if (filament()->isSidebarCollapsibleOnDesktop())
                    x-show="$store.sidebar.isOpen"
                    x-cloak
                @endif
            >
                <span class="acremann-sidebar-user-name">{{ filament()->getUserName($user) }}</span>
                <span class="acremann-sidebar-user-email">{{ $user->email }}</span>
            </div>
        </div>

        <form action="{{ filament()->getLogoutUrl() }}" method="post" class="acremann-sidebar-logout-form">
            @csrf
            <button type="submit" class="acremann-sidebar-logout-btn">
                <x-filament::icon icon="heroicon-o-arrow-left-end-on-rectangle" class="h-5 w-5 shrink-0" />
                <span @if (filament()->isSidebarCollapsibleOnDesktop()) x-show="$store.sidebar.isOpen" x-cloak @endif>
                    {{ __('filament-panels::layout.actions.logout.label') }}
                </span>
            </button>
        </form>
    </div>
@endif
