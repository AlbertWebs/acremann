@props(['icon' => null])

@php
    $key = $icon ?? 'default';
    $svgClass = $attributes->get('class', 'h-6 w-6');
@endphp

@if($key === 'land')
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="{{ $svgClass }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5M4.5 21V9.75A2.25 2.25 0 0 1 6.75 7.5h10.5A2.25 2.25 0 0 1 19.5 9.75V21M6 21v-4.5h12V21"/></svg>
@elseif($key === 'advisory')
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="{{ $svgClass }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
@elseif($key === 'legal')
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="{{ $svgClass }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
@elseif($key === 'global')
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="{{ $svgClass }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c2.485 0 4.5-4.03 4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A8.966 8.966 0 0 1 3 12c0-.778.099-1.533.284-2.253"/></svg>
@else
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="{{ $svgClass }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-16.5 0V9.75A2.25 2.25 0 0 1 6.75 7.5h10.5a2.25 2.25 0 0 1 2.25 2.25V21M6 21h12"/></svg>
@endif
