@props(['type' => 'button', 'variant' => 'primary', 'class' => ''])

@php
    $baseClasses = 'inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm';
    
    $variants = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800 hover:shadow-md hover:-translate-y-0.5 focus:ring-slate-900',
        'secondary' => 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 hover:border-slate-300 focus:ring-slate-200',
        'accent' => 'bg-slate-900 text-white hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 focus:ring-slate-900 border border-transparent',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . $class;
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
