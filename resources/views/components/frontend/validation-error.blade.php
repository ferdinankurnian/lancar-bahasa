@props(['name'])

@if ($errors->has($name))
    <span {{ $attributes->merge(['class' => 'text-danger text-sm']) }}>
        {{ $errors->first($name) }}
    </span>
@endif