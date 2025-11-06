@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center bg-gradient-to-r from-edubridge-pink to-edubridge-pink-light text-white shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200'
            : 'inline-flex items-center text-gray-700 hover:bg-gradient-to-r hover:from-edubridge-blue/20 hover:to-edubridge-pink/20 hover:text-edubridge-pink transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
