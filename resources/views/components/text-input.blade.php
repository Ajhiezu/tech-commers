@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input-neu w-full']) }}>
