@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] ' . $class]) }}>
    {{ $slot }}
</div>
