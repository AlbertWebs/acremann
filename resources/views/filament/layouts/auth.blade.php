@php
    use Filament\Support\Enums\Width;

    $livewire ??= null;
    $renderHookScopes = $livewire?->getRenderHookScopes();
    $maxContentWidth ??= (filament()->getSimplePageMaxContentWidth() ?? Width::Large);

    if (is_string($maxContentWidth)) {
        $maxContentWidth = Width::tryFrom($maxContentWidth) ?? $maxContentWidth;
    }
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    <div class="acremann-auth-layout">
        @include('filament.auth.brand-panel')

        <div class="acremann-auth-main">
            <main
                @class([
                    'fi-simple-main acremann-auth-form-shell',
                    ($maxContentWidth instanceof Width) ? "fi-width-{$maxContentWidth->value}" : $maxContentWidth,
                ])
            >
                @php($authSettings = \App\Models\SiteSetting::current())
                <div class="acremann-auth-card">
                    <div class="acremann-auth-card-top">
                        <a href="{{ config('acremann.url') }}" class="acremann-auth-form-logo-link" target="_blank" rel="noopener noreferrer">
                            @if ($logo = $authSettings->themeLogoUrl())
                                <img src="{{ $logo }}" alt="{{ $authSettings->company_name }}" class="acremann-auth-form-logo">
                            @else
                                <span class="acremann-auth-form-logo-text">{{ $authSettings->company_name }}</span>
                            @endif
                        </a>
                        <span class="acremann-auth-cms-badge">CMS</span>
                    </div>
                    {{ $slot }}
                </div>
                <p class="acremann-auth-help">
                    Trouble signing in?
                    <a href="mailto:{{ $authSettings->email ?: config('acremann.email') }}">Contact {{ $authSettings->email ?: config('acremann.email') }}</a>
                </p>
            </main>
        </div>
    </div>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_LAYOUT_END, scopes: $renderHookScopes) }}
</x-filament-panels::layout.base>
