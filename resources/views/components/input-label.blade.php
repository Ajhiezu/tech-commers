<label {{ $attributes->merge(['class' => 'block text-xs font-black uppercase tracking-widest text-neu-black mb-2']) }}>
    {{ $value ?? $slot }}
</label>
