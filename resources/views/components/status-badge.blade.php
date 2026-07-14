@props(['status'])

@php
    $styles = [
        'pending'   => 'bg-amber-50 text-amber-700',
        'paid'      => 'bg-brand-50 text-brand-700',
        'shipped'   => 'bg-blue-50 text-blue-700',
        'delivered' => 'bg-green-50 text-green-700',
    ][$status] ?? 'bg-gray-100 text-gray-600';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize $styles"]) }}>
    {{ $status }}
</span>
