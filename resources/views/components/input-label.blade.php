@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-capstone-red mb-2']) }}>
    {{ $value ?? $slot }}
</label>
