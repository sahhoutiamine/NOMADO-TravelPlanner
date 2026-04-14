@props(['disabled' => false])

<div class="relative">
    @if(isset($icon))
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
            {{ $icon }}
        </div>
    @endif
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-slate-900 sm:text-sm py-2.5 transition-colors placeholder:text-slate-400 ' . (isset($icon) ? 'pl-10 ' : 'pl-4 ')]) !!}>
</div>
